<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StuntingData;

class StuntingDataSeeder extends Seeder {
    public function run() {
        StuntingData::insert([
            [
                'province' => 'Jawa Tengah',
                'district' => 'Semarang',
                'year' => 2024,
                'stunting_rate' => 19.8,
                'target_rate' => 18.0
            ],
            [
                'province' => 'Jawa Barat',
                'district' => 'Bandung',
                'year' => 2024,
                'stunting_rate' => 21.5,
                'target_rate' => 19.5
            ],
            [
                'province' => 'DKI Jakarta',
                'district' => null,
                'year' => 2024,
                'stunting_rate' => 17.2,
                'target_rate' => 16.0
            ]
        ]);
    }
}
