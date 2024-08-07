<?php

namespace App\Imports;

use App\Models\Bill;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BillImport implements ToCollection , WithCalculatedFormulas ,WithHeadingRow 
{
    /**
     * @param Collection $collection
     */
    public $type;
    public function __construct($type){
        $this->type = $type;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
                if (count(array_filter($row->toArray())) === 0) {
                continue;
               }
               Bill::create([
                'invoice_date' => Date::excelToDateTimeObject($row['invoice_date'])->format('Y-m-d') ?? null,
                'due_date' => Date::excelToDateTimeObject($row['due_date'])->format('Y-m-d') ?? null,
                'bill_tran_date' => Date::excelToDateTimeObject($row['transaction_date'])->format('Y-m-d') ?? null,
                'bill_open' => Date::excelToDateTimeObject($row['open']) ?? null,
                'bill_close' => Date::excelToDateTimeObject($row['close']) ?? null,
                'contract_no' => $row['contract_no'] ?? null,
                'unit' => $row['unit'] ?? null,
                'meter' => $row['meter_no'] ?? null,
                'p_time' => $row['previous_time'] ?? null,
                't_time' => $row['this_time'] ?? null ,
                'p_unit' => $row['diff'] ?? round($row['time_diff']  * 60,9) ?? null,
                'price_unit' => $row['rate']  ?? null,
                'status' => $row['status'] ?? null,
                'type' => $this->type,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);
        }
    }

    public function headingRow(): int
    {
        return 2;
    }
}
