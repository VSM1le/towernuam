<?php

namespace App\Livewire;

use App\Exports\GroupedByContractExport;
use App\Imports\BillImport;
use App\Models\Bill;
use App\Models\CustomerRental;
use App\Models\InvoiceHeader;
use App\Models\ProductService;
use App\Models\PsGroup;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BillWE extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $type;
    public $typeQuery = "WA";
    public $bills;
    public $monthYear;
    public $showImportModal = false;

    public $showGenerateInvoice = false;
    public $showDeleteBill = false;
    
    public function __construct(){
        $this->monthYear = Carbon::now()->format('Y-m');
    }
    public function bill()
    {
        // Validate the uploaded file
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt,xls,xlsx',
            'type' => 'required',
        ]);

        // Check if the file is set
        if (!$this->csvFile) {
            session()->flash('error', 'No file uploaded');
            return;
        }

        try {
        // Import the file
        Excel::import(new BillImport($this->type), $this->csvFile);
        
        // Provide feedback to the user
        session()->flash('success', 'File imported successfully!');
        $this->closeImport();
        } catch (\Exception $e) {
        // Handle exceptions and provide feedback
        session()->flash('error', 'Failed to import file: ' . $e->getMessage());
        $this->closeImport();
        } 
        
    }
    public function openImport(){
        $this->showImportModal = true;
    }
    public function closeImport(){
        $this->showImportModal = false;
        $this->reset(['csvFile']);
    }

    public function openGenInvoice()
    {
        $this->showGenerateInvoice = true;
    }

    public function closeGenInvoice(){
        $this->showGenerateInvoice = false;
    } 

    public function genInvoice(){
        $monthYear = $this->monthYear ?? Carbon::now()->format('Y-m');

        $sumBill = Bill::when($monthYear, function ($query) use($monthYear) {
                $query->where('invoice_date', 'like', '%' . $monthYear . '%');
            })
            ->when($this->typeQuery, function ($query) {
                $query->where('type', $this->typeQuery);
            })
            ->where('status', 'Y')
            ->select(
                'contract_no',
                'invoice_date',
                'due_date',
                'price_unit',
                DB::raw('SUM(p_unit) as total_sales')
            )
            ->groupBy(
                'contract_no',
                'invoice_date',
                'due_date',
                'price_unit'
            )
            ->get(); 
        $prefix = 'IAS';
        $year = Carbon::parse($this->monthYear)->format('Y');
        $datePart = substr($year, -2) . Carbon::parse($this->monthYear)->format('m');

        $lastInvoice = InvoiceHeader::where('inv_no', 'like', $prefix . $datePart . '%')
            ->orderBy('inv_no', 'desc')->first();
        $generatedInvoices = [];

        // Create the set of expected invoice numbers and find the gaps
        // for ($i = 1; count($generatedInvoices) < count($sumBill); $i++) {
        //     $expectedInvoice = $prefix . $datePart . str_pad($i, 4, '0', STR_PAD_LEFT);
        //     if (!isset($existingInvoicesSet[$expectedInvoice])) {
        //         $generatedInvoices[] = $expectedInvoice;
        //     }
        // } 
        if (is_null($lastInvoice)) {
            foreach($sumBill as $index => $bill){
                 $generatedInvoices[] = $prefix . $datePart . str_pad(1 + $index, 4, '0', STR_PAD_LEFT);
                }
            
        } else {
            foreach($sumBill as $index => $bill){
            $lastNumber = (int)substr($lastInvoice->inv_no, -4);
            $newNumber = str_pad($lastNumber + 1 + $index, 4, '0', STR_PAD_LEFT);
            $generatedInvoices[]= $prefix . $datePart . $newNumber;
            }
        }

        if($this->typeQuery == "WA"){
            $product = ProductService::where('ps_code','2002')->first();
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));
            $period = $carbon_date->copy()->day(16)->format('d/m/Y') . " - " . $carbon_date->copy()->addMonth()->day(6)->format('d/m/Y');
            $whtax = $product->ps_whtax ?? 0;
        }
        elseif($this->typeQuery == "EC"){
            $product = ProductService::where('ps_code','2001')->first();
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));
            $start = $carbon_date->copy()->subMonth()->day(4)->format('d/m/Y');
            $end = $carbon_date->copy()->day(3)->format('d/m/Y');
            $period = $start . " - " . $end;
            $whtax = $product->ps_whtax ?? 0;
        }
        else{
            $product = ProductService::where('ps_code','3001')->first();
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));

            $start = $carbon_date->copy()->addMonth()->startOfMonth()->format('d/m/Y');
            $end = $carbon_date->copy()->addMonth()->endOfMonth()->format('d/m/Y');
            $period = $start . " - " . $end;
            $whtax = $product->ps_whtax ?? 0;
        }

        foreach($sumBill as $index => $bill){
            $contractInfo = CustomerRental::where('custr_contract_no',$bill->contract_no)->first(); 
            $amt = round($bill->total_sales * $bill->price_unit,2);
            if($this->typeQuery == "OT"){
                $amt = round($bill->total_sales * ($bill->price_unit / 0.041666667),2);
            }
            if($contractInfo->customer->cust_gov_flag === 1)
            {
                $whtax = 1;
            }
            if($contractInfo->customer->cust_gov_flag === 3)
            {
                $whtax = 0;
            }
            $vatamt = round(($amt * $product->ps_vat ?? 0)/100,2);
            $whamt = round(($amt * $whtax)/100,2);
            $netamt = $amt + $vatamt;
            $createInvoice = InvoiceHeader::create([
            'inv_no' => $generatedInvoices[$index],
            'customer_id' => $contractInfo->customer_id,
            'customer_rental_id' => $contractInfo->id,
            'inv_date' => $bill->invoice_date,
            'invd_duedate' => $bill->due_date,
            'ps_group_id' => PsGroup::where('ps_group',$this->typeQuery)->pluck('id')->first(),
            'inv_status' => 'USE',
            'inv_unite' => $contractInfo->custr_unit ?? null, 
            'inv_tower' => 'A',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
          $createInvoice->invoicedetail()->create([
                'invd_product_code' => $product->ps_code,
                'invd_product_name' => $product->ps_name_th,
                'invd_period' => $period,
                'invd_amt' => $amt,
                'invd_vat_percent' => $product->ps_vat ?? 0,
                'invd_vat_amt' => $vatamt,
                'invd_wh_tax_percent' => $whtax,
                'invd_wh_tax_amt' => $whamt,
                'invd_net_amt' => $netamt,
                'invd_receipt_flag' => "No",
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
        $this->closeGenInvoice();
    }

    public function exportGroupByContract()
    {
       $monthYear = $this->monthYear ?? Carbon::now()->format('Y-m');
       $data = Bill::join('customer_rentals', 'bill.contract_no', '=', 'customer_rentals.custr_contract_no')
            ->select(
                'bill.id',
                'bill.contract_no',
                'bill.unit', 
                'bill.meter',
                'bill.p_time',
                'bill.t_time',
                'bill.p_unit',
                'bill.price_unit',
                'bill.invoice_date', 
                'bill.due_date',
                'bill.bill_tran_date',
                'bill.bill_open',
                'bill.bill_close',
                'bill.bill_use',
                'customer_rentals.custr_contract_no_real as real_contract'  
            )
            ->when($monthYear, function ($query) use($monthYear) {
                $query->where('invoice_date', 'like', '%' . $monthYear . '%');
            })
            ->when($this->typeQuery, function ($query){
                $query->where('type',$this->typeQuery);
            })
            ->where('status','Y')
            ->get(); 
        if($this->typeQuery == "WA"){
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));
            $period = $carbon_date->copy()->day(16)->format('d/m/Y') . " - " . $carbon_date->copy()->addMonth()->day(6)->format('d/m/Y');
        }
        elseif($this->typeQuery == "EC"){
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));
            $start = $carbon_date->copy()->subMonth()->day(4)->format('d/m/Y');
            $end = $carbon_date->copy()->day(3)->format('d/m/Y');
            $period = $start . " - " . $end;
        }
        else{
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));

            $start = $carbon_date->copy()->addMonth()->startOfMonth()->format('d/m/Y');
            $end = $carbon_date->copy()->addMonth()->endOfMonth()->format('d/m/Y');
            $period = $start . " - " . $end;
        }
            return Excel::download(new GroupedByContractExport($data,$this->typeQuery,$period), 'bills_grouped_by_contract.xlsx');
    }

    public function openClear(){
        $this->showDeleteBill = true;
    }
    public function clearBill(){

        $monthYear = $this->monthYear ?? Carbon::now()->format('Y-m');
        try{
            Bill::when($monthYear, function($query) use($monthYear){
                $query->where('invoice_date','like','%'.$monthYear.'%');
                })
            ->when($this->typeQuery, function($query){
                $query->where('type',$this->typeQuery);
            })->delete();
            session()->flash('success', ' Clear Bill successful'); 
        }catch(\Exception $e){
            session()->flash('error', ' Error can not clear Bill'); 
        }finally{
            $this->closeClear();
        }
    }
    public function closeClear(){
        $this->showDeleteBill = false;
    }

    public function render()
    {   
       $monthYear = $this->monthYear ?? Carbon::now()->format('Y-m');
       $this->bills = Bill::when($monthYear, function ($query) use($monthYear)  {
       $query->where('invoice_date', 'like', '%' . $monthYear. '%');
       })
       ->when($this->typeQuery, function ($query){
        $query->where('type',$this->typeQuery);
       })
       ->where('status','Y')
       ->get();
 
        return view('livewire.bill-w-e',['bills'=> $this->bills]);
    }
}
