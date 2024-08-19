<?php

namespace App\Exports;

use App\Models\CustomerRental;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractSheetExport implements WithCustomStartCell, WithStyles,WithHeadings
{
    protected $contractNo;
    protected $items;
    protected $type;
    protected $period;
    protected $vat;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($contractNo, $items,$type,$period,$vat)
    {
        $this->contractNo = $contractNo;
        $this->items = $items;
        $this->type = $type;
        $this->period = $period;
        $this->vat = $vat;
    } 

    public function startCell():string{
        return "B8";
    }
    public function headings(): array
    {
        if($this->type == "OT"){
            return ['Transantion Date', 'Unit', 'Unit Air','Open','Close','Hours of use','Price/Hr','Amount'];
        }
        else{
           return ['Unit','Meter No.','Period','Previous','This Time','Unit','price/unit','Amount']; 
        }
        
    }

    public function styles(Worksheet $sheet){
        $customerName = CustomerRental::where('custr_contract_no_real',$this->items->first()->real_contract)->first();
        $logo= new Drawing();
        $logo->setName('nuam');
        $logo->setDescription('nuam'); 
        $logo->setPath(public_path('nuam.jpg'));
        $logo->setCoordinates('B1');
        $logo->setWidth(600);
        $logo->setHeight(110);
        $logo->setWorksheet($sheet);
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getRowDimension(1)->setRowHeight(42);
        $sheet->mergeCells("A1:I1");
        $sheet->setCellValue('A1',"บริษัท นวม จำกัด");
        $sheet->getStyle("A1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A1")->getFont()->setSize(18);
        if($this->type == "WA"){
            $sheet->setCellValue('A2',"รายงานการใช้น้ำประปา");
        }elseif($this->type == "EC"){
            $sheet->setCellValue('A2',"รายงานการใช้ไฟฟ้า");
        }else{
            $sheet->setCellValue('A2',"รายงานการใช้ไอเย็นล่วงเวลา");
        }

        $sheet->getStyle("A2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A2")->getFont()->setSize(18);
        $sheet->getRowDimension(2)->setRowHeight(35);
        $sheet->mergeCells("A2:I2");
        $sheet->getRowDimension(4)->setRowHeight(25);
        $sheet->getColumnDimension('B')->setWidth(17);
        $sheet->setCellValue("B4","Due Date :");
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->setCellValue("B5","Building :");
        $sheet->getRowDimension(6)->setRowHeight(25);
        $sheet->setCellValue("B6","Customer Code :");
        $sheet->getRowDimension(7)->setRowHeight(25);
        // $sheet->setCellValue("B7","Meter Type :");
        $sheet->getRowDimension(8)->setRowHeight(27);
        $sheet->getColumnDimension('C')->setWidth(19);
        $sheet->setCellValue("C4",Carbon::parse($this->items->first()->due_date)
                                        ->format('d-m-Y'));
        $sheet->setCellValue("C5",'อาคารนวม');
        $sheet->setCellValue("C6",$customerName->customer->cust_name_th ." (เลขที่สัญญา ".$this->items->first()->real_contract.")");
        // $sheet->setCellValue("C7",$this->items->first()->due_date);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getColumnDimension('I')->setWidth(20);

        $sheet->getStyle("B8:I8")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
        for($col = 'B'; $col<= "I";$col++){
            $sheet->getStyle("{$col}8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}8")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        }
         $total_amt = 0;
        $currentRow = 9;
        if($this->type != "OT"){
        foreach($this->items as $bill)
        {
            $sheet->getRowDimension($currentRow)->setRowHeight(25);
            $sheet->getStyle("B{$currentRow}:D{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->setCellValue("B{$currentRow}",$bill->unit);
            $sheet->setCellValue("C{$currentRow}",$bill->meter);
            $sheet->setCellValue("D{$currentRow}",$this->period);
            $sheet->setCellValue("E{$currentRow}",Carbon::parse($bill->p_time)->format('d-m-Y'));
            $sheet->setCellValue("F{$currentRow}",Carbon::parse($bill->t_time)->format('d-m-Y'));
            $sheet->setCellValue("G{$currentRow}",$bill->p_unit);
            $sheet->setCellValue("H{$currentRow}",$bill->price_unit);
            $sheet->setCellValue("I{$currentRow}",round($bill->p_unit * $bill->price_unit,2));
            $currentRow += 1;
        } 
        }
        else{
            foreach($this->items as $bill){
                $minutes = $bill->p_unit;
                $amt = round($bill->p_unit * ($bill->price_unit / 0.041666667),2);
                $sheet->getStyle("B{$currentRow}:H{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->setCellValue("B{$currentRow}",Carbon::parse($bill->bill_tran_date)->format('d-m-Y'));
                $sheet->setCellValue("C{$currentRow}",$bill->unit);
                $sheet->setCellValue("D{$currentRow}",$bill->meter);
                $sheet->setCellValue("E{$currentRow}",$bill->bill_open);
                $sheet->setCellValue("F{$currentRow}",$bill->bill_close);
                $sheet->setCellValue("G{$currentRow}",$minutes);
                $sheet->getStyle("G{$currentRow}")->getNumberFormat()->setFormatCode('H:mm');
                $sheet->setCellValue("H{$currentRow}",$bill->price_unit);
                $sheet->setCellValue("I{$currentRow}",$amt);
                $total_amt += $amt;
                $currentRow += 1;
            }
        }
        $vat_amt = ($total_amt * $this->vat) / 100;  
        $sheet->mergeCells("B".$currentRow.":H".$currentRow);
        $sheet->setCellValue("B{$currentRow}","Amount");
        $sheet->setCellValue("I{$currentRow}",$total_amt);
        $sheet->mergeCells("B".($currentRow + 1).":H".($currentRow + 1));
        $sheet->setCellValue("B".($currentRow + 1),"VAT ".$this->vat."%");
        $sheet->setCellValue("I".($currentRow + 1),$vat_amt);
        $sheet->setCellValue("B".($currentRow + 2),"Total Amount");
        $sheet->mergeCells("B".($currentRow + 2).":H".($currentRow + 2));
        $sheet->setCellValue("I".($currentRow + 2),$total_amt + $vat_amt);
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $sheet->getRowDimension($currentRow + 1)->setRowHeight(25);
        $sheet->mergeCells("B".($currentRow + 2).":H".($currentRow + 2));
        $sheet->setCellValue("I".($currentRow + 2),$total_amt + $vat_amt);
        $sheet->getRowDimension($currentRow)->setRowHeight(25);
        $sheet->getRowDimension($currentRow + 1)->setRowHeight(25);
        $sheet->getRowDimension($currentRow + 2)->setRowHeight(25);
        $sheet->getStyle("B".($currentRow).":B".($currentRow + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("B".($currentRow). ":B".($currentRow + 2))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("B".($currentRow).":I".($currentRow + 2))->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
    }
    public function registerEvents(): array
            {
                return[ 
                    AfterSheet::class => function(AfterSheet $event) {
                    // Set paper size to A4
                    $event->sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
                    $event->sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                    // Set print margins (units are in inches)
                    $event->sheet->getPageMargins()->setTop(0.5);
                    $event->sheet->getPageMargins()->setBottom(0.5);
                    $event->sheet->getPageMargins()->setLeft(0.5);
                    $event->sheet->getPageMargins()->setRight(0.5);
                 },
                    ];
            }
}
