<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('housing_facts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id');
            $table->foreignId('area_id');
            //$table->foreignId('year_id');
            $table->foreignId('dataset_id');
            $table->decimal('value', 12, 1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_facts');
    }
};
