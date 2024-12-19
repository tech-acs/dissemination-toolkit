<?php

namespace Uneca\DisseminationToolkit\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\ValidationException;
use Uneca\DisseminationToolkit\Models\Dataset;
use Uneca\DisseminationToolkit\Notifications\TaskCompletedNotification;
use Uneca\DisseminationToolkit\Notifications\TaskFailedNotification;
use Uneca\DisseminationToolkit\Traits\Geospatial;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Spatie\SimpleExcel\SimpleExcelReader;

class ImportDatasetJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use Geospatial;

    const CHUNK_SIZE = 500;
    public $timeout = 1800; // 30 minutes

    public function __construct(
        private Dataset $dataset,
        private string $filePath,
        private array $lookups,
        private array $columnMapping,
        private User $user,
        private string $locale
    ) {}

    private function lookItUp($key, $dimension, $lookups): array
    {
        $map = $lookups[$dimension];
        return [$map['fk'], $map['lookup'][strtolower($key)] ?? null];
    }

    public function handle()
    {
        $dataFile = SimpleExcelReader::create($this->filePath);//->formatHeadersUsing(fn($header) => strtolower(trim($header)));
        $rows = $dataFile->getRows();
        $inserted = 0;
        $rows->chunk(self::CHUNK_SIZE)->each(function ($chunk, $chunkIndex) use (&$inserted) {
            $entries = [];
            $chunk->each(function (array $row, $rowIndexWithinAChunk) use ($chunkIndex, $inserted, &$entries) {
                $commonForMultipleIndicators = ['dataset_id' => $this->dataset->id];
                foreach ($this->columnMapping['dimensions'] as $dimensionId => $dimensionColumn) {
                    list($foreignKeyCol, $valueId) = $this->lookItUp($row[$dimensionColumn], $dimensionId, $this->lookups);
                    $commonForMultipleIndicators[$foreignKeyCol] = $valueId;
                }
                foreach ($this->columnMapping['others'] as $dimensionId => $dimensionColumn) {
                    list($foreignKeyCol, $valueId) = $this->lookItUp($row[$dimensionColumn], $dimensionId, $this->lookups);
                    $commonForMultipleIndicators[$foreignKeyCol] = $valueId;
                }
                foreach ($this->columnMapping['indicators'] as $indicatorId => $valueColumn) {
                    $entry = [...$commonForMultipleIndicators];
                    $entry['indicator_id'] = $indicatorId;
                    $entry['value'] = (float) $row[$valueColumn];

                    if (in_array(null, $entry, true)) {
                        $lineNo = self::CHUNK_SIZE * $chunkIndex + $rowIndexWithinAChunk + 2;
                        logger("Dataset import error on line $lineNo", ['ENTRY' => $entry, 'ROW' => $row]);
                        // ToDo: You're in a job now!
                        throw ValidationException::withMessages([
                            'datafile' => "The data seems to contain invalid data (unknown dimension value, etc.) at the following row (around line $lineNo).<br><br>".
                                implode(', ', $row).
                                "<br><br>".
                                "$inserted rows were imported. Please correct and re-import.<br>Remember to empty the dataset first to avoid duplicates."
                        ]);
                    } else {
                        array_push($entries, $entry);
                    }
                }
            });
            $result = DB::table($this->dataset->fact_table)->insertOrIgnore($entries);
            $inserted += $result;
            //dump("Inserted so far: $inserted");
        });
        Notification::sendNow($this->user, new TaskCompletedNotification(
            'Task completed',
            'The dataset import process has been completed.',
        ));
    }

    public function failed(\Throwable $exception)
    {
        logger('ImportDatasetJob Job Failed', ['Exception: ' => $exception->getMessage()]);
        Notification::sendNow($this->user, new TaskFailedNotification(
            'Task failed',
            $exception->getMessage()
        ));
    }
}
