<?php

namespace Database\Seeders;

use App\Models\Dimension;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DimensionValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dimensions = [
            'sex' => [
                ['code' => '_T', 'name' => 'Both sexes'],
                ['code' => 'm', 'name' => 'Male'],
                ['code' => 'f', 'name' => 'Female'],
            ],
            'five_year_age_group' => [
                ['code' => '_T', 'name' => 'Total'],
                ['code' => '0-4', 'name' => '0-4'],
                ['code' => '5-9', 'name' => '5-9'],
                ['code' => '10-14', 'name' => '10-14'],
                ['code' => '15-19', 'name' => '15-19'],
                ['code' => '20-24', 'name' => '20-24'],
                ['code' => '25-29', 'name' => '25-29'],
                ['code' => '30-34', 'name' => '30-34'],
                ['code' => '35-39', 'name' => '35-39'],
                ['code' => '40-44', 'name' => '40-44'],
                ['code' => '45-49', 'name' => '45-49'],
                ['code' => '50-54', 'name' => '50-54'],
                ['code' => '55-59', 'name' => '55-59'],
                ['code' => '60-64', 'name' => '60-64'],
                ['code' => '65-69', 'name' => '65-69'],
                ['code' => '70-74', 'name' => '70-74'],
                ['code' => '75-79', 'name' => '75-79'],
                ['code' => '80-84', 'name' => '80-84'],
                ['code' => '85-89', 'name' => '85-89'],
                ['code' => '90-94', 'name' => '90-94'],
                ['code' => '95+', 'name' => '95+'],
            ],
            'ten_year_age_group' => [
                ['code' => '_T', 'name' => 'Total'],
                ['code' => '0-9', 'name' => '0-9'],
                ['code' => '10-19', 'name' => '10-19'],
                ['code' => '20-29', 'name' => '20-29'],
                ['code' => '30-39', 'name' => '30-39'],
                ['code' => '40-49', 'name' => '40-49'],
                ['code' => '50-59', 'name' => '50-59'],
                ['code' => '60-69', 'name' => '60-69'],
                ['code' => '70-79', 'name' => '70-79'],
                ['code' => '80-89', 'name' => '80-89'],
                ['code' => '90+', 'name' => '90+'],
            ],
            'urban_rural' => [
                ['code' => '_T', 'name' => 'Total'],
                ['code' => 'ur', 'name' => 'Urban'],
                ['code' => 'ru', 'name' => 'Rural'],
            ],
            'year' => [
                ['code' => '1991', 'name' => '1991'],
                ['code' => '2001', 'name' => '2001'],
                ['code' => '2011', 'name' => '2011'],
                ['code' => '2023', 'name' => '2023'],
            ]
        ];
        foreach ($dimensions as $dimensionTable => $values) {
            if (Schema::hasTable($dimensionTable)) {
                foreach ($values as $value) {
                    DB::table($dimensionTable)->insert($value);
                }
            } else {
                dump("Dimension table $dimensionTable does not exist. Run the 'data:create-dimensions' command");
            }
        }
    }
}
