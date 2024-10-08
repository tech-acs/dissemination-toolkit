<?php

namespace Database\Seeders;

use App\Models\Dimension;
use Illuminate\Database\Seeder;

class DimensionsSeeder extends Seeder
{
    public function run(): void
    {
        $dimensions = [
            ['name' => 'Year', 'table_name' => 'year', 'for' => ['population_facts', 'housing_facts']],
            ['name' => 'Sex', 'table_name' => 'sex', 'for' => ['population_facts']],
            ['name' => 'Five year age group', 'table_name' => 'five_year_age_group', 'for' => ['population_facts']],
            ['name' => 'Ten year age group', 'table_name' => 'ten_year_age_group', 'for' => ['population_facts']],
            ['name' => 'Urban/rural', 'table_name' => 'urban_rural', 'for' => ['population_facts', 'housing_facts']],
        ];
        foreach ($dimensions as $dimension) {
            Dimension::create($dimension);
        }
    }
}
