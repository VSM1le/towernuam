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
                'CUST_CODE' => 'A0001',
                'CUST_NAME_TH' => 'นางสาว ฐิติภา แจ้งจงดี',
                'CUST_TAXID' => '1100900385577',
                'CUST_ADDRESS_TH1' => '899/3 หมู่ที่ 9 ถนน- ตำบลสำโรงเหนือ อำเภอเมืองสมุทรปราการ จังหวัดสมุทรปราการ',
                'CUST_ZIPCODE' => '10270',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'N',
                'CUST_INVAUTO' => 'Y',
                'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0002',
                'CUST_NAME_TH' => 'บริษัท พี เอ เอ สตูดิโอ จำกัด',
                'CUST_TAXID' => '0105547122032',
                'CUST_ADDRESS_TH1' => '66  อาคารคิวเฮ้าส์ อโศก ชั้น 11 ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'CUST_ZIPCODE' => '10110',
                'CUST_FLOOR' => '11',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0003',
                'CUST_NAME_TH' => 'บริษัท มิทซูนามิ (ประเทศไทย) จำกัด',
                'CUST_TAXID' => '0105549062461',
                'CUST_ADDRESS_TH1' => '66  อาคารนวม ชั้น 11  ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'CUST_ZIPCODE' => '10110',
                'CUST_FLOOR' => '11',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0004',
                'CUST_NAME_TH' => 'บริษัท แอลเอ็มซี ออโตโมทีฟ (ประเทศไทย) จำกัด',
                'CUST_TAXID' => '0105554108261',
                'CUST_ADDRESS_TH1' => '66  อาคารนวม ชั้น 11 ห้องเลขที่ 1106  ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'CUST_ZIPCODE' => '10110',
                'CUST_FLOOR' => '11',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0005',
                'CUST_NAME_TH' => 'บริษัท จีดีเอ็น จำกัด',
                'CUST_TAXID' => '0125542001881',
                'CUST_ADDRESS_TH1' => '66 ชั้น 11 อาคารคิวเฮ้าส์ อโศก ถนนสุขุมวิท 21(อโศก) แขวงคลองเตยเหนือ',
                'CUST_ADDRESS_EN1' => 'Sukhumvit 21 (Asoke)',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0006',
                'CUST_NAME_TH' => 'บริษัท อูช่า สยาม สตีล อินดัสตรียส์  จำกัด (มหาชน)',
                'CUST_TAXID' => '0107540000022',
                'CUST_ADDRESS_TH1' => '101/46  หมู่ 20  ถนนพหลโยธิน ตำบลคลองหนึ่ง  อำเภอคลองหลวง  จังหวัดปทุมธานี',
                'CUST_ZIPCODE' => '12120',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0007',
                'CUST_NAME_TH' => 'บริษัท จีวีเอ็ม โกลบอล จำกัด',
                'CUST_TAXID' => '0105560060321',
                'CUST_ADDRESS_TH1' => '66 ชั้น 12 ห้อง 1211 ซอย 21 (อโศก) ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ',
                'CUST_ADDRESS_EN1' => 'Sukhumvit 21 (Asoke)',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0008',
                'CUST_NAME_TH' => 'บริษัท เอเอ็มแอล ซีสเต็มส์ จำกัด ',
                'CUST_TAXID' => '0105558005997',
                'CUST_ADDRESS_TH1' => 'เลขที่ 66 ห้องเลขที่ 1212 ชั้น 12 ซ.21 (อโศก) ถ. สุขุมวิท 21 แขวงคลองเตยเหนือ',
                'CUST_ADDRESS_EN1' => 'Sukhumvit 21 (Asoke)',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
            [
                'CUST_CODE' => 'A0009',
                'CUST_NAME_TH' => 'บริษัท อินเตอร์เนชั่นแนล แอดมินิสเตรชั่น (ประเทศไทย)',
                'CUST_TAXID' => '0105537054573',
                'CUST_ADDRESS_TH1' => '66  ซ.สุขุมวิท 21 ถนนสุขุมวิท 21 (อโศก) แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพมหานคร',
                'CUST_ADDRESS_EN1' => 'Sukhumvit 21 (Asoke)',
                'CUST_BRANCH' => 'Head Office',
                'CUST_E_UNITCOST' => 6.5,
                'CUST_CALVAT' => 'Y',
                'CUST_CALWHTAX' => 'Y',
                'CUST_INVAUTO' => 'Y',
                 'created_by' => 1,
                'updated_by' => 1
            ],
        ];

         foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
}
