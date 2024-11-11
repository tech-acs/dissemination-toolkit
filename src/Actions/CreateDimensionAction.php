<?php

namespace Uneca\DisseminationToolkit\Actions;

use Uneca\DisseminationToolkit\Models\Dimension;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimensionAction
{
    private function createTable(string $table, array $columns): bool
    {
        if (! Schema::hasTable($table)) {
            try {
                Schema::create($table, function (Blueprint $table) use ($columns) {
                    $table->id();
                    foreach ($columns as $column => $columnDetails) {
                        $table->addColumn($columnDetails['type'] ?? 'string', $column, $columnDetails['parameters'] ?? []);
                    }
                });
            } catch (\Exception $exception) {
                logger("Error in CreateDimensionAction action (createTable function)", ['Exception message' => $exception->getMessage()]);
                return false;
            }
        }
        return true;
    }

    public function handle(Dimension $dimension)
    {
        $columns = [
            'code' => [
                'type' => 'string',
                'parameters' => ['length' => 25, 'unique' => true],
            ],
            'name' => [
                'type' => 'string',
            ]
        ];
        $tableName = $dimension->table_name;
        $tableExists = $this->createTable($tableName, $columns);
        if ($tableExists) {
            $dimension->update(['table_created_at' => now()]);
            foreach ($dimension->for as $factTable) {
                try {
                    Schema::table($factTable, function (Blueprint $table) use ($tableName) {
                        $table->foreignId($tableName . '_id')->nullable();
                    });
                } catch (\Exception $exception) {
                    logger("Error in CreateDimensionAction (handle function)", ['Exception message' => $exception->getMessage()]);
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
