<?php

namespace App\Livewire;

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

        // Explicitly specify the file type
        Excel::import(new BillImport($this->type), $this->csvFile);

        // Provide feedback to the user
        session()->flash('success', 'File imported successfully!');
        $this->closeImport();
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

    $sumBill = Bill::when($this->monthYear, function ($query) {
                $query->where('invoice_date', 'like', '%' . $this->monthYear . '%');
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
        // dd($sumBill);
        $prefix = 'IAS';
        $year = Carbon::parse($this->monthYear)->format('Y');
        $datePart = substr($year, -2) . Carbon::parse($this->monthYear)->format('m');

        $existingInvoices = InvoiceHeader::where('inv_no', 'like', $prefix . $datePart . "%")
            ->where('inv_status', '!=', 'CANCEL')
            ->orderBy('inv_no', 'asc')
            ->pluck('inv_no')
            ->toArray();

        $existingInvoicesSet = array_flip($existingInvoices); // For faster lookups
        $generatedInvoices = [];

        // Create the set of expected invoice numbers and find the gaps
        for ($i = 1; count($generatedInvoices) < count($sumBill); $i++) {
            $expectedInvoice = $prefix . $datePart . str_pad($i, 4, '0', STR_PAD_LEFT);
            if (!isset($existingInvoicesSet[$expectedInvoice])) {
                $generatedInvoices[] = $expectedInvoice;
            }
        } 
        if($this->typeQuery == "WA"){
            $product = ProductService::where('ps_code','2002')->first();
            $carbon_date = Carbon::parse($this->monthYear ?? Carbon::now()->format('Y-m'));
            $period = $carbon_date->copy()->day(16)->format('d/m/Y') . " - " . $carbon_date->copy()->addMonth()->day(15)->format('d/m/Y');
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
            if($contractInfo->customer->cust_gov_flag === 3)
            {
                $whtax = 1;
            }
            if($contractInfo->customer->cust_gov_flag === 1)
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
    public function render()
    {
       $monthYear = $this->monthYear ?? Carbon::now()->format('Y-m');
       $this->bills = Bill::when($monthYear, function ($query) use($monthYear) {
       $query->where('invoice_date', 'like', '%' . $monthYear  . '%');
       })
       ->when($this->typeQuery, function ($query){
        $query->where('type',$this->typeQuery);
       })
       ->where('status','Y')
       ->get();
 
        return view('livewire.bill-w-e',['bills'=> $this->bills]);
    }
}
