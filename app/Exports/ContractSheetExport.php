<?php

namespace App\Exports;

use App\Models\CustomerRental;
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
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($contractNo, $items,$type,$period)
    {
        $this->contractNo = $contractNo;
        $this->items = $items;
        $this->type = $type;
        $this->period = $period;
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
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->setCellValue("B4","Due Date :");
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->setCellValue("B5","Building :");
        $sheet->getRowDimension(6)->setRowHeight(25);
        $sheet->setCellValue("B6","Customer Code :");
        $sheet->getRowDimension(7)->setRowHeight(25);
        $sheet->setCellValue("B7","Meter Type :");
        $sheet->getRowDimension(8)->setRowHeight(27);
        $sheet->getColumnDimension('C')->setWidth(19);
        $sheet->setCellValue("C4",$this->items->first()->due_date);
        $sheet->setCellValue("C5",'อาคารนวม');
        $sheet->setCellValue("C6",$customerName->customer->cust_name_th ." (เลขที่สัญญา ".$this->items->first()->real_contract.")");
        $sheet->setCellValue("C7",$this->items->first()->due_date);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(17);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(17);
        $sheet->getColumnDimension('I')->setWidth(20);

        for($col = 'A'; $col<= "I";$col++){
            $sheet->getStyle("{$col}8")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("{$col}8")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("{$col}8")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
        }
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
            $sheet->setCellValue("E{$currentRow}",$bill->p_time);
            $sheet->setCellValue("F{$currentRow}",$bill->t_time);
            $sheet->setCellValue("G{$currentRow}",$bill->p_unit);
            $sheet->setCellValue("H{$currentRow}",$bill->price_unit);
            $sheet->setCellValue("I{$currentRow}",round($bill->p_unit * $bill->price_unit,2));
            $currentRow += 1;
        } 
        }
        else{
            foreach($this->items as $bill){
                $sheet->getStyle("B{$currentRow}:H{$currentRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("B{$currentRow}:I{$currentRow}")->getBorders()->getAllborders()->setBorderStyle(Border::BORDER_THIN);
                $sheet->setCellValue("B{$currentRow}",$bill->bill_tran_date);
                $sheet->setCellValue("C{$currentRow}",$bill->unit);
                $sheet->setCellValue("D{$currentRow}",$this->period);
                $sheet->setCellValue("E{$currentRow}",$bill->bill_open);
                $sheet->setCellValue("F{$currentRow}",$bill->bill_close);
                $minutes = $bill->p_unit /60 ;
                $sheet->setCellValue("G{$currentRow}",$minutes);
                $sheet->getStyle("G{$currentRow}")->getNumberFormat()->setFormatCode('H:mm');
                $sheet->setCellValue("H{$currentRow}",$bill->price_unit);
                $sheet->setCellValue("I{$currentRow}",round($bill->p_unit * $bill->price_unit,2));
                $currentRow += 1;
            }

        }
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
