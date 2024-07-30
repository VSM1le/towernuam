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
        // dd($rows);
        foreach ($rows as $index => $row) {
               Bill::create([
                'invoice_date' => Date::excelToDateTimeObject($row['invoice_date'])->format('d/m/Y') ?? null,
                'due_date' => Date::excelToDateTimeObject($row['due_date'])->format('d/m/Y') ?? null,
                'contract_no' => $row['contract_no'] ?? null,
                'unit' => $row['unit'] ?? null,
                'meter' => $row['meter_no'] ?? null,
                'p_time' => $row['previous_time'] ?? null,
                't_time' => $row['this_time'] ?? null ,
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
