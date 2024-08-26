<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvoiceExport implements WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $invoice;
    public function __construct($invoice){
        $this->invoice = $invoice;
    }
    public function headings(): array
    {
        return ['Invoice Status','Invoice No.','invoice Date','Due Date','Customer name' ,'Contract Number','Service Code','Product','Amt','Vat','Vat Amt','Wh Tax','Whtax Amt','Net Amt','Status','Paid Amount','Remark'];
    }
    public function styles(Worksheet $sheet){
        $column = 2;
        foreach($this->invoice as $invoiceDetails){
            foreach($invoiceDetails->invoicedetail as $detail){
               $sheet->setCellValue("A$column",$invoiceDetails->inv_status); 
               $sheet->setCellValue("B$column",$invoiceDetails->inv_no); 
               $sheet->setCellValue("C$column",$invoiceDetails->inv_date); 
               $sheet->setCellValue("D$column",$invoiceDetails->invd_duedate); 
               $sheet->setCellValue("E$column",$invoiceDetails->customer->cust_name_th); 
               $sheet->setCellValue("F$column",$invoiceDetails->customerrental->custr_contract_no ?? null); 
               $sheet->setCellValue("G$column",$detail->invd_product_code ?? null); 
               $sheet->setCellValue("H$column",$detail->invd_product_name ?? null); 
               $sheet->setCellValue("I$column",$detail->invd_amt ?? 0); 
               $sheet->setCellValue("J$column",$detail->invd_vat_percent ?? 0); 
               $sheet->setCellValue("K$column",$detail->invd_amt ?? 0); 
               $sheet->setCellValue("L$column",$detail->invd_wh_tax_percent ?? 0); 
               $sheet->setCellValue("M$column",$detail->invd_wh_tax_amt ?? 0); 
               $sheet->setCellValue("N$column",$detail->invd_net_amt ?? 0); 
               $sheet->setCellValue("O$column",$detail->invd_receipt_flag); 
               $sheet->setCellValue("P$column",$detail->invd_receipt_amt ?? 0); 
               $sheet->setCellValue("Q$column",$detail->invd_remark ?? null); 
               $column += 1;
            } 
        }
    }
}
