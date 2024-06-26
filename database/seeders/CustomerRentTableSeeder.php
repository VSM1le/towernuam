<?php

namespace Database\Seeders;

use App\Models\CustomerRental;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerRentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contracts = [
            [
                'customer_id' => 1,
                'CUSTR_NO' => 1,
                'CUSTR_CONTRACT_NO' => 'N2307007',
                'CUSTR_TOWER' => 'A',
                'CUSTR_UNIT' => 'G03',
                'CUSTR_FLOOR' => null,
                'CUSTR_ZONE' => null,
                'CUSTR_SUB_ZONE' => null,
                'CUSTR_AREA_SQM' => 71,
                'CUSTR_RENTAL_FEE' => 320,
                'CUSTR_SERVICE_FEE' => 480,
                'CUSTR_EQUIPMENT_FEE' => 0,
                'CUSTR_BEGIN_DATE2' => '2023-10-01',
                'CUSTR_END_DATE2' => '2026-09-30',
                'CUSTR_CONTRACT_YEAR' => 3,
                 'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'customer_id' => 2,
                'CUSTR_NO' => 1,
                'CUSTR_CONTRACT_NO' => 'N2212002',
                'CUSTR_TOWER' => 'A',
                'CUSTR_UNIT' => '1101',
                'CUSTR_FLOOR' => null,
                'CUSTR_ZONE' => null,
                'CUSTR_SUB_ZONE' => null,
                'CUSTR_AREA_SQM' => 135,
                'CUSTR_RENTAL_FEE' => 256,
                'CUSTR_SERVICE_FEE' => 384,
                'CUSTR_EQUIPMENT_FEE' => 0,
                'CUSTR_BEGIN_DATE2' => '2022-12-01',
                'CUSTR_END_DATE2' => '2025-11-30',
                'CUSTR_CONTRACT_YEAR' => 3,
                 'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'customer_id' => 3,
                'CUSTR_NO' => 1,
                'CUSTR_CONTRACT_NO' => 'N2212003',
                'CUSTR_TOWER' => 'A',
                'CUSTR_UNIT' => '1104',
                'CUSTR_FLOOR' => null,
                'CUSTR_ZONE' => null,
                'CUSTR_SUB_ZONE' => null,
                'CUSTR_AREA_SQM' => 99,
                'CUSTR_RENTAL_FEE' => 150,
                'CUSTR_SERVICE_FEE' => 200,
                'CUSTR_EQUIPMENT_FEE' => 0,
                'CUSTR_BEGIN_DATE2' => '2022-12-01',
                'CUSTR_END_DATE2' => '2025-11-30',
                'CUSTR_CONTRACT_YEAR' => 3,
                 'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'customer_id' => 4,
                'CUSTR_NO' => 1,
                'CUSTR_CONTRACT_NO' => 'N2212004',
                'CUSTR_TOWER' => 'A',
                'CUSTR_UNIT' => '1106,1107',
                'CUSTR_FLOOR' => null,
                'CUSTR_ZONE' => null,
                'CUSTR_SUB_ZONE' => null,
                'CUSTR_AREA_SQM' => 238,
                'CUSTR_RENTAL_FEE' => 150,
                'CUSTR_SERVICE_FEE' => 200,
                'CUSTR_EQUIPMENT_FEE' => 0,
                'CUSTR_BEGIN_DATE2' => '2022-12-01',
                'CUSTR_END_DATE2' => '2025-11-30',
                'CUSTR_CONTRACT_YEAR' => 3,
                 'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'customer_id' => 5,
                'CUSTR_NO' => 1,
                'CUSTR_CONTRACT_NO' => 'N-2404001',
                'CUSTR_TOWER' => 'A',
                'CUSTR_UNIT' => '1105',
                'CUSTR_FLOOR' => null,
                'CUSTR_ZONE' => null,
                'CUSTR_SUB_ZONE' => null,
                'CUSTR_AREA_SQM' => 70,
                'CUSTR_RENTAL_FEE' => 200,
                'CUSTR_SERVICE_FEE' => 300,
                'CUSTR_EQUIPMENT_FEE' => 0,
                'CUSTR_BEGIN_DATE2' => '2024-05-01',
                'CUSTR_END_DATE2' => '2025-11-30',
                'CUSTR_CONTRACT_YEAR' => 1.7,
                 'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'customer_id' => 6,
                'CUSTR_NO' => 1,
                'CUSTR_CONTRACT_NO' => 'N2212007',
                'CUSTR_TOWER' => 'A',
                'CUSTR_UNIT' => '1207',
                'CUSTR_FLOOR' => null,
                'CUSTR_ZONE' => null,
                'CUSTR_SUB_ZONE' => null,
                'CUSTR_AREA_SQM' => 135,
                'CUSTR_RENTAL_FEE' => 150,
                'CUSTR_SERVICE_FEE' => 200,
                'CUSTR_EQUIPMENT_FEE' => 0,
                'CUSTR_BEGIN_DATE2' => '2022-12-01',
                'CUSTR_END_DATE2' => '2025-11-30',
                'CUSTR_CONTRACT_YEAR' => 3,
                 'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        // Insert data using Eloquent
        foreach ($contracts as $contractData) {
            CustomerRental::create($contractData);
        }
    }

}
