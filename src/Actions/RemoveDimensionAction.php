<?php

namespace Uneca\DisseminationToolkit\Actions;

use Uneca\DisseminationToolkit\Models\Dimension;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDimensionAction
{
    private function dropTable(string $table): bool
    {
        if (Schema::hasTable($table)) {
            try {
                Schema::drop($table);
                return true;
            } catch (\Exception $exception) {
                logger("Error in RemoveDimensionAction (dropTable function)", ['Exception message' => $exception->getMessage()]);
                return false;
            }
        }
        return true;
    }

    public function handle(Dimension $dimension)
    {
        $tableName = $dimension->table_name;
        $tableRemoved = $this->dropTable($tableName);
        if ($tableRemoved) {
            foreach ($dimension->for as $factTable) {
                try {
                    Schema::table($factTable, function (Blueprint $table) use ($tableName) {
                        $table->dropColumn($tableName . '_id');
                    });
                } catch (\Exception $exception) {
                    logger("Error in RemoveDimensionAction (handle function)", ['Exception message' => $exception->getMessage()]);
                }
            }
            $dimension->delete();
            return true;
        } else {
            return false;
        }
    }
}
