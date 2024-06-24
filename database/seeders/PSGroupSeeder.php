<?php

namespace Database\Seeders;

use App\Models\PsGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PSGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $psGroups = [
            [
                'ps_group' => 'RF',
                'ps_desc' => 'Rental Fee',
                'begin_date' => 1,
                'end_date' => 31,
            ],
            [
                'ps_group' => 'CF',
                'ps_desc' => 'Car Park Fee',
                'begin_date' => 15,
                'end_date' => 16,
            ],
            [
                'ps_group' => 'EW',
                'ps_desc' => 'Electric Water Fee',
                'begin_date' => 8,
                'end_date' => 7,
            ],
            [
                'ps_group' => 'OT',
                'ps_desc' => 'Other Fee',
                'begin_date' => 1,
                'end_date' => 31,
            ],
        ];
        foreach ($psGroups as $psGroup) {
            PsGroup::create($psGroup);
        }

    // PsGroup::create([
    //     'PS_GROUP' => 'RF',
    //     'PS_DESC' => 'Rental Fee',
    //     'BEGIN_DATE' => 1,
    //     'END_DATE' => 31,
    // ]);
    }
}
