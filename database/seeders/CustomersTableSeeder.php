<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'cust_code' => 'A0001',
                'cust_name_th' => 'นางสาว สุภชา จารุจินดา',
                'cust_name_en' => 'Miss Suphacha Charuchinda',
                'cust_taxid' => '1100900385577',
                'cust_address_th1' => '899/3 หมู่ที่ 9 ถนน- ตำบลสำโรงเหนือ อำเภอเมืองสมุทรปราการ จังหวัดสมุทรปราการ',
                'cust_zipcode' => '10270',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'N',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0002',
                'cust_name_th' => 'บริษัท พี เอ เอ สตูดิโอ จำกัด',
                'cust_name_en' => 'P A A STUDIO COMPANY LIMITED',
                'cust_taxid' => '0105547122032',
                'cust_address_th1' => '66  อาคารคิวเฮ้าส์ อโศก ชั้น 11 ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '11',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0003',
                'cust_name_th' => 'บริษัท มิทซูนามิ (ประเทศไทย) จำกัด',
                'cust_name_en' => 'MITSUNAMI (THAILAND) CO.,LTD.',
                'cust_taxid' => '0105549062461',
                'cust_address_th1' => '66  อาคารนวม ชั้น 11  ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '11',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0004',
                'cust_name_th' => 'บริษัท แอลเอ็มซี ออโตโมทีฟ (ประเทศไทย) จำกัด',
                'cust_name_en' => 'LMC AUTOMOTIVE (THAILAND) CO.,LTD.',
                'cust_taxid' => '0105554108261',
                'cust_address_th1' => '66  อาคารนวม ชั้น 11 ห้องเลขที่ 1106  ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '11',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0005',
                'cust_name_th' => 'บริษัท จีดีเอ็น จำกัด',
                'cust_name_en' => 'G D N CO.,LTD.',
                'cust_taxid' => '0125542001881',
                'cust_address_th1' => '66 ชั้น 11 อาคารคิวเฮ้าส์ อโศก ถนนสุขุมวิท 21(อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '11',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0006',
                'cust_name_th' => 'บริษัท อูช่า สยาม สตีล อินดัสตรียส์  จำกัด (มหาชน)',
                'cust_name_en' => 'USHA SIAM STEEL INDUSTRIES PUBLIC COMPANY LIMITED',
                'cust_taxid' => '0107540000022',
                'cust_address_th1' => '101/46  หมู่ 20  ถนนพหลโยธิน ตำบลคลองหนึ่ง  อำเภอคลองหลวง  จังหวัดปทุมธานี',
                'cust_zipcode' => '12120',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0007',
                'cust_name_th' => 'บริษัท จีวีเอ็ม โกลบอล จำกัด',
                'cust_name_en' => 'GVM GLOBAL COMPANY LIMITED',
                'cust_taxid' => '0105560060321',
                'cust_address_th1' => '66 ชั้น 12 ห้อง 1211 ซอย 21 (อโศก) ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '12',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0008',
                'cust_name_th' => 'บริษัท เอเอ็มแอล ซีสเต็มส์ จำกัด',
                'cust_name_en' => 'AML SYSTEMS COMPANY LIMITED',
                'cust_taxid' => '0105558005997',
                'cust_address_th1' => 'เลขที่ 66 ห้องเลขที่ 1212 ชั้น 12 ซ.21 (อโศก) ถนนสุขุมวิท แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '12',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0009',
                'cust_name_th' => 'บริษัท อินเตอร์เนชั่นแนล แอดมินิสเตรชั่น (ประเทศไทย) จำกัด',
                'cust_name_en' => 'INTERNATIONAL ADMINISTRATION (THAILAND) CO., LTD.',
                'cust_taxid' => '0105537054573',
                'cust_address_th1' => '66  ซ.สุขุมวิท 21 ถนนสุขุมวิท 21 (อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0010',
                'cust_name_th' => 'บริษัท ไทย โคะคุไซ จำกัด',
                'cust_name_en' => 'THAI KOKUSAI CO.,LTD.',
                'cust_taxid' => '0105549005637',
                'cust_address_th1' => '66 อาคารนวม  ห้อง 1404 ชั้น 14 ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '14',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0011',
                'cust_name_th' => 'บริษัท เค-มิล เมทัล จำกัด',
                'cust_name_en' => 'K-MILL METAL CO.,LTD.',
                'cust_taxid' => '0105549011599',
                'cust_address_th1' => '66  ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0012',
                'cust_name_th' => 'Tosplant Engineering (Thailand) Co., Ltd.',
                'cust_name_en' => 'Tosplant Engineering (Thailand) Co., Ltd.',
                'cust_taxid' => '0105536020942',
                'cust_address_th1' => '66,15th Floor,  Sukhumvit 21 (Asoke)  Rd. North Klongtoey, Watthana, Bangkok',
                'cust_zipcode' => '10110',
                'cust_floor' => '15',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0013',
                'cust_name_th' => 'บริษัท ดิจิตอล ไซแอน เทคโนโลยี จำกัด',
                'cust_name_en' => 'DIGITAL SCIENCE TECHNOLOGY CO.,LTD.',
                'cust_taxid' => '0105545066232',
                'cust_address_th1' => '66 อาคารนวม  ชั้น 15 ห้อง 1508  ถนนสุขุมวิท 21 (อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '15',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Head Office',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0014',
                'cust_name_th' => 'บริษัท ไทย ฟูคูดะ จำกัด',
                'cust_name_en' => 'THAI FUKUDA CORPORATION CO., LTD.',
                'cust_taxid' => '0105535083576',
                'cust_address_th1' => '66  อาคารนวม ชั้น 15  ห้อง 1509-1510  ถนนอโศก (สุขุมวิท 21) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '15',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0015',
                'cust_name_th' => 'บริษัท ทีพีเอสซี (ไทยแลนด์) จำกัด',
                'cust_name_en' => 'TPSC (THAILAND) CO.,LTD.',
                'cust_taxid' => '0105553076969',
                'cust_address_th1' => '66  ชั้นที่ 15  ถนนสุขุมวิท 21 (อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '15',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0016',
                'cust_name_th' => 'บริษัท แพทย์รัตนิน จำกัด',
                'cust_name_en' => 'RUTNIN MEDICAL ASSOCIATES CO., LTD.',
                'cust_taxid' => '0105538123226',
                'cust_address_th1' => '80/1 ถนนอโศก (สุขุมวิท 21) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0017',
                'cust_name_th' => 'บริษัท สตาร์ ทรานสเลชั่น แอนด์ ซอฟแวร์ (ประเทศไทย) จำกัด',
                'cust_name_en' => 'STAR TRANSLATION & SOFTWARE (THAILAND) CO.,LTD.',
                'cust_taxid' => '0105540057081',
                'cust_address_th1' => '66 อาคารนวม ชั้นที่ 18 ซอยอโศก ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '18',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A0018',
                'cust_name_th' => 'ธนาคารอิสลามแห่งประเทศไทย',
                'cust_name_en' => 'Islamic Bank of Thailand',
                'cust_taxid' => '0993000275063',
                'cust_address_th1' => '66 อาคารนวม ชั้น B,M,12,14,18,20-23 ถ.สุขุมวิท 21(อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => 'B,M,12,14,18,20-23',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'cust_gov_flag' => true,
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A3001',
                'cust_name_th' => 'บริษัท ลุฟท์ฮันซ่า เซอร์วิสเซส (ไทยแลนด์) จำกัด',
                'cust_name_en' => 'LUFTHANSA (THAILAND) SERVICES CO., LTD.',
                'cust_taxid' => '0105536134735',
                'cust_address_th1' => '66  ถนนสุขุมวิท 21  (อโศก)  แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'cust_zipcode' => '10110',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => 'Branch 00002',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A3002',
                'cust_name_th' => 'บริษัท ลุฟท์ฮันซ่า เซอร์วิสเซส (ไทยแลนด์) จำกัด',
                'cust_name_en' => 'LUFTHANSA (THAILAND) SERVICES CO., LTD.',
                'cust_taxid' => '0105536134735',
                'cust_address_th1' => '999 อาคารคอนคอร์ส เอ4-091เอ หมู่ที่ 1 ถนนบางนาตราด กม.15 ตำบลราชาเทวะ อำเภอบางพลี จังหวัดสมุทรปราการ',
                'cust_zipcode' => '10540',
                'cust_floor' => '',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'cust_code' => 'A3003',
                'cust_name_th' => 'LUFTHANSA GERMAN AIRLINE',
                'cust_name_en' => 'LUFTHANSA GERMAN AIRLINE',
                'cust_taxid' => '0993000029453',
                'cust_address_th1' => '16TH FLOOR,Nuam Building, 66 SUKHUMVIT SOI 21, North Klongtoey, Watthana, Bangkok',
                'cust_zipcode' => '10110',
                'cust_floor' => '16TH FLOOR',
                'cust_calvat' => 'Y',
                'cust_calwhtax' => 'Y',
                'cust_invauto' => 'Y',
                'cust_branch' => '',
                'cust_e_unitcost' => '6.500',
                'created_by' => 1,
                'updated_by' => 1
            ],
            
        ];

        foreach ($customers as $customerData) {
            // Check if a customer with the same cust_code exists
            $existingCustomer = Customer::where('cust_code', $customerData['cust_code'])->first();
            
            // If the customer doesn't exist, create a new one
            if (is_null($existingCustomer)) {
                Customer::create($customerData);
            }
        }
    }
}
