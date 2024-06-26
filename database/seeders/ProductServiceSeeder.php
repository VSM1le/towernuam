<?php

namespace Database\Seeders;

use App\Models\ProductService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $productServices = [
            ['ps_code' => '1001', 'ps_abb' => 'Rental', 'ps_name_th' => 'ค่าเช่า', 'ps_name_en' => 'Rental Fee', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'RF', 'ps_group_id' => 1, 'ps_vat' => 0, 'ps_whtax' => 5, 'ps_tower' => null, 'ps_price_gr' => '1', 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1010', 'ps_abb' => 'Rental', 'ps_name_th' => 'ค่าเช่าพื้นที่สำนักงาน', 'ps_name_en' => 'Rental For Office Space', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'A1', 'ps_group_id' => 1, 'ps_vat' => 0, 'ps_whtax' => 5, 'ps_tower' => null, 'ps_price_gr' => '1', 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1020', 'ps_abb' => 'Rental', 'ps_name_th' => 'ค่าเช่าพื้นที่ - ห้องเก็บของ', 'ps_name_en' => 'Rental For Storage', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'A1', 'ps_group_id' => 1, 'ps_vat' => 0, 'ps_whtax' => 5, 'ps_tower' => null, 'ps_price_gr' => '2', 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1030', 'ps_abb' => 'ServiceF', 'ps_name_th' => 'ค่าบริการสาธารณูปโภค', 'ps_name_en' => 'Service For Utilities', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'A1', 'ps_group_id' => 1, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => '3', 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1033', 'ps_abb' => 'CRC', 'ps_name_th' => 'ค่าบริการห้องประชุม', 'ps_name_en' => 'Conference Room Charge', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1034', 'ps_abb' => 'CC', 'ps_name_th' => 'ค่าบริการระบบสื่อสาร', 'ps_name_en' => 'Communication Charge', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1035', 'ps_abb' => null, 'ps_name_th' => 'ค่าบริการ - สถานที่ติดตั้งอุปกรณ์สื่อสาร', 'ps_name_en' => 'Service - Communication Station', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1036', 'ps_abb' => null, 'ps_name_th' => 'ค่าบริการกล่องไฟป้ายโฆษณา', 'ps_name_en' => 'Sign Light Box Service Fee', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1037', 'ps_abb' => null, 'ps_name_th' => 'ค่าบริการสถานที่ติดตั้งจาน Wireless,True', 'ps_name_en' => 'Wireless,True', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1038', 'ps_abb' => null, 'ps_name_th' => 'ค่าบริการเชื่อมต่อสัญญาณ', 'ps_name_en' => null, 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '1039', 'ps_abb' => null, 'ps_name_th' => 'ค่าบริการจัดการจอภาพแอลซีดี', 'ps_name_en' => null, 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '2002', 'ps_abb' => 'Elec', 'ps_name_th' => 'ค่าไฟฟ้า', 'ps_name_en' => 'Electricity Charge', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'EW', 'ps_group_id' => 3, 'ps_vat' => 7, 'ps_whtax' => null, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '3001', 'ps_abb' => 'OTAir', 'ps_name_th' => 'ค่าบริการไอเย็นล่วงเวลา', 'ps_name_en' => 'OT Air', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'OA', 'ps_group_id' => 3, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '4001', 'ps_abb' => 'Carpark', 'ps_name_th' => 'ค่าบริการที่จอดรถ-ผู้มาติดต่อ', 'ps_name_en' => 'Visitor Parking Service', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'CF', 'ps_group_id' => 2, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '4010', 'ps_abb' => 'Carpark', 'ps_name_th' => 'ค่าบริการที่จอดรถรายเดือน', 'ps_name_en' => 'Monthly Parking', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'CF1', 'ps_group_id' => 2, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '4012', 'ps_abb' => 'Carpark', 'ps_name_th' => 'ค่าบริการที่จอดรถ-ภายนอกอาคาร', 'ps_name_en' => 'Outside Parking', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'CFO', 'ps_group_id' => 2, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '4013', 'ps_abb' => 'Carpark', 'ps_name_th' => 'ค่าบริการที่จอดรถ-ภายในอาคาร', 'ps_name_en' => 'Inside Parking', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'CFI', 'ps_group_id' => 2, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '5001', 'ps_abb' => 'SJ', 'ps_name_th' => 'ค่าบริการซ่อมแซม', 'ps_name_en' => 'Service Job', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'O1', 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '5010', 'ps_abb' => 'ServiceC', 'ps_name_th' => 'ค่าบริการอื่นๆ', 'ps_name_en' => 'Service Charge', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => 'SC', 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => 3, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
            ['ps_code' => '2001', 'ps_abb' => null, 'ps_name_th' => 'ค่าน้ำประปา', 'ps_name_en' => 'Water Charge', 'ps_unit' => null, 'ps_price' => null, 'ps_type' => null, 'ps_group_id' => null, 'ps_vat' => 7, 'ps_whtax' => null, 'ps_tower' => null, 'ps_price_gr' => null, 'created_by' => 1,
                'updated_by' => 1,],
        ];

        foreach ($productServices as $service) {
            ProductService::create($service);
        }
    }
}
