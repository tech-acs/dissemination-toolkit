<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkingDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DimensionsSeeder::class,
            IndicatorsSeeder::class,
            //DimensionValueSeeder::class,
        ]);
        DB::statement("INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, created_at, updated_at) VALUES (1, 0, '{\"en\": \"Country\"}', 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
        DB::statement("INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, created_at, updated_at) VALUES (2, 1, '{\"en\": \"Region\"}', 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
        DB::statement("INSERT INTO public.area_hierarchies (id, index, name, zero_pad_length, simplification_tolerance, created_at, updated_at) VALUES (3, 2, '{\"en\": \"Constituency\"}', 0, 0, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
    }
}
