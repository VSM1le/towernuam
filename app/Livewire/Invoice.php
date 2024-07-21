<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerRental;
use App\Models\InvoiceDetail;
use App\Models\InvoiceHeader;
use App\Models\ProductService;
use App\Models\PsGroup;
use App\Services\numberToBath;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Options;
use Illuminate\Support\Carbon as SupportCarbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Invoice extends Component
{
    use WithPagination;
    public $psGroup = null;
    public $customerName = null;
    public $customerCode = null;
    public $customerrents = null;
    public $rental = null;
    public $service = null;
    public $invoiceDate = null;
    public $invoiceDetails;
    public $dueDate = null;
    public $tower = "A";
    public $showCreateInvoice = false;



    public $showEditInvoice = false;

    public $editInvoices = null;
    public $editInvoiceNumber = null;
    public $editInvoiceDetails = [];
    public $editPsGroup = null;
    public $editInvoiceDate = null;
    public $editDueDate = null;
    public $editCustomerCode = null;
    public $editRental = null;
    public $deleteItem;
    public $editcustomerrents = [];

    public $startDate;
    public $endDate;
    public $customer;
    private function sanitizeNumericValue($value)
    {
        $sanitizedValue = preg_replace('/[^-?\d.]/', '', $value);

        return (float) $sanitizedValue;
    }

    public function updatedCustomerCode(){
        $this->rental = null;
        $this->invoiceDetails = [];
          if (!is_null($this->customerCode)) {
            $this->customerrents = CustomerRental::where('customer_id',$this->customerCode)->get();
        } else {
            $this->customerrents = null;    
        }
        
    }

    public function updateInvoiceDetail($index, $field, $value)
    {
        if($this->invoiceDetails[$index][$field] == null){
            $this->invoiceDetails[$index][$field] = 0;
        }
        if (isset($this->invoiceDetails[$index]) && $this->invoiceDetails[$index]['amt'] != null) {
            $this->invoiceDetails[$index][$field] = $value;

            // Recalculate vatamt if amt or vat field is updated
            if ($field == 'amt' || $field == 'vat' || $field == 'whvat') {
                $amt = $this->invoiceDetails[$index]['amt'] ?? 0;
                $vat = $this->sanitizeNumericValue($this->invoiceDetails[$index]['vat'] ?? 0); // Sanitize vat value
                $whvat = $this->sanitizeNumericValue($this->invoiceDetails[$index]['whvat'] ?? 0);// Sanitize whvat value

                $vatamt = ($amt * $vat) / 100 ?? 0;
                $whtaxamt = ($amt * $whvat) / 100 ?? 0;
                $netamt = $vatamt + $amt;
                
                $this->invoiceDetails[$index]['vatamt'] = round($vatamt,2);
                $this->invoiceDetails[$index]['whtaxamt'] = round($whtaxamt,2);
                $this->invoiceDetails[$index]['netamt'] = round($netamt, 2); 
            }
        }
    }


    #[Computed()]
    public function customers(){
        return Customer::all();
    }

    #[Computed()]
    public function psgroups(){
        return PsGroup::all();
    }

    #[Computed()]
    public function productservices(){
        return ProductService::all();
    }

    public function addline(){
       $this->validate([
            'invoiceDate' => ['required'],
            'customerCode'  => ['required'],
            'service' => ['required'],
            'psGroup' => ['required'],
            'dueDate' => ['required'],
       ]); 
        $check = True;
        $customer_rent= CustomerRental::where('customer_id',$this->customerCode)->where('id',$this->rental)->with('customer')->first();
        $product_service = ProductService::where('id',$this->service)->first();
        $ps_group = PsGroup::where('id',$this->psGroup)->first();
        $wh_tax = $product_service->ps_whtax;
        if($ps_group->begin_date == '1' && $ps_group->end_date == '31'){

            $carbon_date = Carbon::parse($this->invoiceDate);

            $start = $carbon_date->copy()->addMonth()->startOfMonth()->format('d/m/Y');
            $end = $carbon_date->copy()->addMonth()->endOfMonth()->format('d/m/Y');
            $period = $start . " - " . $end;
        }
        elseif($ps_group->begin_date == '8' && $ps_group->end_date == '7'){
            $carbon_date = Carbon::parse($this->invoiceDate);
            $start = $carbon_date->copy()->subMonth()->day(4)->format('d/m/Y');
            $end = $carbon_date->copy()->day(3)->format('d/m/Y');
            $period = $start . " - " . $end;
        }
        else{
            $carbon_date = Carbon::parse($this->invoiceDate);
            $period = $carbon_date->copy()->day($ps_group->begin_date)->format('d/m/Y') . " - " . $carbon_date->copy()->addMonth()->day($ps_group->end_date)->format('d/m/Y');
        }
        
       if(Customer::where('id',$this->customerCode)->pluck('cust_gov_flag')->first() == 1){
            $wh_tax = $product_service->gov_whtax;
       } 
       if(Customer::where('id',$this->customerCode)->pluck('cust_gov_flag')->first() == 3){
            $wh_tax = 0;
       }
        if(($product_service->ps_code == "1001" || $product_service->ps_code == "1010") && !is_null($customer_rent)){
            $amt = $customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $wh_tax)/100;
            $netamt = $amt + $vatamt ;
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period ?? 0
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>round($vatamt,2)
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => round($whamt,2) 
            ,'netamt'=>round($netamt, 2) 
            ,'remark'=>''];
            $check = false;
        }
        if($product_service->ps_code == '1020' && !is_null($customer_rent)){
            $amt = $customer_rent->custr_area_sqm * $customer_rent->custr_service_fee;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $wh_tax)/100;
            $netamt = $amt + $vatamt; 
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>round($vatamt,2)
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => round($whamt,2) 
            ,'netamt'=> round($netamt, 2) 
            ,'remark'=>''];
            $check = false;
        }
        if($check){
             $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=> 0
            ,'vat'=> $product_service->ps_vat 
            ,'vatamt'=> 0
             ,'whvat'=>$wh_tax 
            ,'whtaxamt' => 0
            ,'netamt'=> 0
            ,'remark'=>''];
        }
    }
    public function removeItem($index){
       unset($this->invoiceDetails[$index]);
       $this->invoiceDetails = array_values($this->invoiceDetails);
    }
    
    public function createInvoice(){
        $this->validate([
            'psGroup' => ['required'],
            'invoiceDate' => ['required'],
            'customerCode'  => ['required'],
            'service' => ['required'],  
            'dueDate' => ['required'],
        ]);
        $prefix = 'I'.$this->tower.'S';
        $year = Carbon::parse($this->invoiceDate)->format('Y');
        $datePart = substr($year,-2) . Carbon::parse($this->invoiceDate)->format('m');
        $unite = CustomerRental::where('id',$this->rental)->first();
        $lastInvoice = InvoiceHeader::where('inv_no', 'like', $prefix . $datePart . '%')->orderBy('inv_no', 'desc')->first();

        if (is_null($lastInvoice)) {
            $invNo = $prefix . $datePart . '0001';
        } else {
            $lastNumber = (int)substr($lastInvoice->inv_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $invNo = $prefix . $datePart . $newNumber;
        }

        $createInvoice = InvoiceHeader::create([
            'inv_no' => $invNo,
            'customer_id' => $this->customerCode,
            'customer_rental_id' => $this->rental,
            'inv_date' => $this->invoiceDate,
            'invd_duedate' => $this->dueDate,
            'ps_group_id' => $this->psGroup,
            'inv_status' => 'USE',
            'inv_unite' => $unite->custr_unit, 
            'inv_tower' => $this->tower,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        foreach ($this->invoiceDetails as $detail) {
            $createInvoice->invoicedetail()->create([
                'invd_product_code' => $detail['pscode'],
                'invd_product_name' => $detail['psname'],
                'invd_period' => $detail['period'],
                'invd_amt' => $detail['amt'],
                'invd_vat_percent' => $detail['vat'],
                'invd_vat_amt' => $detail['vatamt'],
                'invd_wh_tax_percent' => $detail['whvat'],
                'invd_wh_tax_amt' => $detail['whtaxamt'],
                'invd_net_amt' => $detail['netamt'],
                'invd_remake' => $detail['remark'],
                'invd_receipt_flag' => "No",
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
        $this->closeCreateInvoice();
        return redirect()->route('dashboard');
    }

    public function openCreateInvoice(){
        $this->showCreateInvoice = true;
    }

    public function closeCreateInvoice(){
        $this->showCreateInvoice = false;
        $this->reset(['psGroup','customerName','customerCode','customerrents','rental','service','invoiceDate','invoiceDetails']);
        $this->resetValidation();
       
    }

    public function updatedEditCustomerCode()
    {
        $this->editRental = null; // Clear dependent data
    
        if (!is_null($this->editCustomerCode)) {
            $this->editcustomerrents = CustomerRental::where('customer_id', $this->editCustomerCode)->get();
        } else {
            $this->editcustomerrents = []; // Ensure the variable is an empty array or null as needed
        }
    }
     public function updateEditInvoiceDetail($index, $field, $value)
    {
        if($this->editInvoiceDetails[$index][$field] == null){
            $this->editInvoiceDetails[$index][$field] = 0;
        }
        if (isset($this->editInvoiceDetails[$index]) && $this->editInvoiceDetails[$index]['amt'] != null) {
            $this->editInvoiceDetails[$index][$field] = $value;

            // Recalculate vatamt if amt or vat field is updated
            if ($field == 'amt' || $field == 'vat' || $field == 'whvat') {
                $amt = $this->editInvoiceDetails[$index]['amt'] ?? 0;
                $vat = $this->sanitizeNumericValue($this->editInvoiceDetails[$index]['vat'] ?? 0); // Sanitize vat value
                $whvat = $this->sanitizeNumericValue($this->editInvoiceDetails[$index]['whvat'] ?? 0); // Sanitize whvat value

                $vatamt = ($amt * $vat) / 100 ?? 0;
                $whtaxamt = ($amt * $whvat) / 100 ?? 0;
                $netamt = $vatamt + $amt;

                $this->editInvoiceDetails[$index]['vatamt'] = round($vatamt,2);
                $this->editInvoiceDetails[$index]['whtaxamt'] = round($whtaxamt,2);
                $this->editInvoiceDetails[$index]['netamt'] = round($netamt,2);
            }
        }
    }

    public function openEditInvoice($id)
    {
        $this->editInvoices = InvoiceHeader::with('invoicedetail')->where('id', $id)->first();
        if ($this->editInvoices) {
            $this->editPsGroup = $this->editInvoices->ps_group_id;
            $this->editInvoiceNumber = $this->editInvoices->inv_no;
            $this->editInvoiceDate = $this->editInvoices->inv_date;
            $this->editCustomerCode = $this->editInvoices->customer_id;
            $this->editcustomerrents = CustomerRental::where('customer_id', $this->editCustomerCode)->get();
            $this->editRental = $this->editInvoices->customer_rental_id;
            $this->editDueDate = $this->editInvoices->invd_duedate;
            foreach ($this->editInvoices->invoicedetail as $invoice) {
                $this->editInvoiceDetails[] = [
                    'id' => $invoice->id,
                    'pscode' => $invoice->invd_product_code,
                    'psname' => $invoice->invd_product_name,
                    'period' => $invoice->invd_period,
                    'amt' => $invoice->invd_amt,
                    'vat' => $invoice->invd_vat_percent,
                    'vatamt' => $invoice->invd_vat_amt,
                    'whvat' => $invoice->invd_wh_tax_percent,
                    'whtaxamt' => $invoice->invd_wh_tax_amt,
                    'netamt' => $invoice->invd_net_amt,
                    'remark' => $invoice->invd_remake,
                ];
            }
            $this->showEditInvoice = true;
        }
    }

     public function editRemove($index)
    {
        $deleteId = $this->editInvoiceDetails[$index]['id']; 
        if(!empty($deleteId)){
        $this->deleteItem[] = ['id'=>$deleteId];
        }
        unset($this->editItemDetails[$index]);
        $this->editInvoiceDetails = array_values($this->editItemDetails);
    }

    public function editAdd(){
        $this->validate([
            'editInvoiceDate' => ['required'],
            'editCustomerCode'  => ['required'],
            'service' => ['required'],
            'editPsGroup' => ['required'],
            'editDueDate' => ['required'],
       ]); 
        $check = True;
        $customer_rent= CustomerRental::where('customer_id',$this->editCustomerCode)->where('id',$this->editRental)->with('customer')->first();
        $product_service = ProductService::where('id',$this->service)->first();
        $ps_group = PsGroup::where('id',$this->editPsGroup)->first();
        $wh_tax = $product_service->ps_whtax;
        if($ps_group->begin_date == '1' && $ps_group->end_date == '31'){

            $carbon_date = Carbon::parse($this->editInvoiceDate);

            $start = $carbon_date->copy()->addMonth()->startOfMonth()->format('d/m/Y');
            $end = $carbon_date->copy()->addMonth()->endOfMonth()->format('d/m/Y');
            $period = $start . " - " . $end;
        }
        else{
            $carbon_date = Carbon::parse($this->editInvoiceDate);
            $period = $carbon_date->copy()->day($ps_group->begin_date)->format('d/m/Y') . " - " . $carbon_date->copy()->addMonth()->day($ps_group->end_date)->format('d/m/Y');
        }
        
       if(Customer::where('id',$this->editCustomerCode)->pluck('cust_gov_flag')->first() == 1){
            $wh_tax = $product_service->gov_whtax;
       } 
        
        if(($product_service->ps_code == "1001" || $product_service->ps_code == "1010") && !is_null($customer_rent)){
            $amt = $customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $wh_tax)/100;
            $netamt =$amt + $vatamt ;
            $this->editInvoiceDetails[] = 
            [
            'id' => null,
            'pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period ?? 0
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$wh_tax
            ,'whtaxamt' => $whamt 
            ,'netamt'=> round($netamt, 2)  
            ,'remark'=>''];
            $check = false;
        }
        if($product_service->ps_code == '1020' && !is_null($customer_rent)){
            $amt = $customer_rent->custr_area_sqm * $customer_rent->custr_service_fee;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $wh_tax)/100;
            $netamt =$amt + $vatamt ;
            $this->editInvoiceDetails[] = 
            [
            'id' => null,
            'pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>round($wh_tax,2)
            ,'whtaxamt' => round($whamt,2) 
            ,'netamt'=>round($netamt, 2)   
            ,'remark'=>''];
            $check = false;
        }
        if($check){
             $this->editInvoiceDetails[] = 
            [
            'id' => null,    
            'pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=> 0
            ,'vat'=> $product_service->ps_vat 
            ,'vatamt'=> 0
             ,'whvat'=>$wh_tax 
            ,'whtaxamt' => 0
            ,'netamt'=> 0
            ,'remark'=>''];
        }
    }

    

    public function editRemoveDetail($index){
       unset($this->editInvoiceDetails[$index]);
       $this->editInvoiceDetails = array_values($this->editInvoiceDetails);
    }

    public function editInvoice()
{
    $this->validate([
        'editInvoiceDate' => ['required'],
        'editCustomerCode'  => ['required'],
        'editPsGroup' => ['required'],
        'editDueDate' => ['required'],
    ]); 

    // Update InvoiceHeader
    $header = InvoiceHeader::find($this->editInvoices->id); // Fetch the InvoiceHeader instance

    if (!$header) {
        // Handle case where InvoiceHeader is not found
        return;
    }

    $header->update([
        'customer_id' => $this->editCustomerCode,
        'inv_no' => $this->editInvoiceNumber,
        'customer_rental_id' => !empty($this->editRental) ? $this->editRental : null,
        'inv_date' => $this->editInvoiceDate,
        'invd_duedate' => $this->editDueDate,
        'ps_group_id' => $this->editPsGroup,
        'inv_unite' => CustomerRental::where('id',$this->editRental)->pluck('custr_unit') ?? null,
        'updated_by' => auth()->id(),
    ]);

    // Collect existing InvoiceDetail IDs
    $existingDetailIds = collect($this->editInvoiceDetails)->pluck('id')->filter();

    // Delete InvoiceDetails that are not in the updated list
    InvoiceDetail::where('invoice_header_id', $header->id)
        ->whereNotIn('id', $existingDetailIds->toArray())
        ->delete();

    // Update or Create InvoiceDetails
    foreach ($this->editInvoiceDetails as $detail) {
        if (isset($detail['id'])) {
            // Update existing InvoiceDetail
            InvoiceDetail::where('id', $detail['id'])->update([
                'invd_product_code' => $detail['pscode'],
                'invd_product_name' => $detail['psname'],
                'invd_period' => $detail['period'],
                'invd_amt' => $detail['amt'],
                'invd_vat_percent' => $detail['vat'],
                'invd_vat_amt' => $detail['vatamt'],
                'invd_wh_tax_percent' => $detail['whvat'],
                'invd_wh_tax_amt' => $detail['whtaxamt'],
                'invd_net_amt' => $detail['netamt'],
                'invd_remake' => $detail['remark'],
                'invd_receipt_flag' => 'No',
                'updated_by' => auth()->id(),
            ]);
        } else {
            // Create new InvoiceDetail with invoice_header_id
            $newDetail = new InvoiceDetail([
                'invoice_header_id' => $header->id,
                'invd_product_code' => $detail['pscode'],
                'invd_product_name' => $detail['psname'],
                'invd_period' => $detail['period'],
                'invd_amt' => $detail['amt'],
                'invd_vat_percent' => $detail['vat'],
                'invd_vat_amt' => $detail['vatamt'],
                'invd_wh_tax_percent' => $detail['whvat'],
                'invd_wh_tax_amt' => $detail['whtaxamt'],
                'invd_net_amt' => $detail['netamt'],
                'invd_remake' => $detail['remark'],
                'invd_receipt_flag' => 'No',
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
            $header->invoicedetail()->save($newDetail); // Save the new detail with relationship
        }
    }
    $this->closeEditModal();
    
}
public function closeEditModal(){
     $this->showEditInvoice = false;
        $this->reset(['editPsGroup','editCustomerCode','editcustomerrents','editRental','editInvoiceDate','editInvoiceDetails']);
        $this->resetValidation();
}

    public function exportPdf($id){
        $number = new numberToBath;
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $invoice = InvoiceHeader::where('id',$id)->with(['invoicedetail','customerrental','customer'])->first();
        $bath = $number->baht_text($invoice->invoicedetail->sum('invd_net_amt'));
        $html1 = view('invoicepdf.invoice4', ['Invoices' => $invoice, 'bath' => $bath])->render();
        $html2 = view('invoicepdf.invoice3', ['Invoices' => $invoice, 'bath' => $bath])->render();
        
        // Combine the HTML and add a page break
        $combinedHtml = $html1 . $html2;
        $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $invoice->inv_no . '.pdf'); 
    } 
      public function exportEngPdf($id){
        $number = new numberToBath;
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $invoice = InvoiceHeader::where('id',$id)->with(['invoicedetail','customerrental','customer'])->first();
        $bath = $number->numberToWords($invoice->invoicedetail->sum('invd_net_amt'));
        $html1 = view('invoicepdf.invoiceengreal', ['Invoices' => $invoice, 'bath' => $bath])->render();
        $html2 = view('invoicepdf.invoiceengcopy', ['Invoices' => $invoice, 'bath' => $bath])->render();
        
        // Combine the HTML and add a page break
        $combinedHtml = $html1 . $html2;
        $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $invoice->inv_no . '.pdf'); 
    } 
    

    
    public function render()
    {
        $invoices = InvoiceHeader::with(['invoicedetail', 'customer'])
        ->when($this->startDate && $this->endDate, function ($query) {
            $query->whereBetween('inv_date', [$this->startDate, $this->endDate]);
        })
        ->when($this->customer != "" ,function ($query){
            $query->where('customer_id',$this->customer);
        })
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('livewire.invoice',compact('invoices'));
    }
}
