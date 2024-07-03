<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerRental;
use App\Models\InvoiceDetail;
use App\Models\InvoiceHeader;
use App\Models\ProductService;
use App\Models\PsGroup;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Options;
use Illuminate\Support\Carbon as SupportCarbon;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Invoice extends Component
{
    public $psGroup = null;
    public $customerName = null;
    public $customerCode = null;
    public $customerrents = null;
    public $rental = null;
    public $service = null;
    public $invoiceDate = null;
    public $invoiceDetails;
    public $tower = "A";
    public $showCreateInvoice = false;

    private function sanitizeNumericValue($value)
    {
        $sanitizedValue = preg_replace('/[^-?\d.]/', '', $value);

        return (float) $sanitizedValue;
    }

    public function updatedCustomerCode(){
        $this->rental = null;
        $this->invoiceDetails = null;
          if (!is_null($this->customerCode)) {
            $this->customerrents = CustomerRental::where('customer_id',$this->customerCode)->get();
        } else {
            $this->customerrents = null;    
        }
        
    }

    public function updateInvoiceDetail($index, $field, $value)
    {
        if (isset($this->invoiceDetails[$index]) && $this->invoiceDetails[$index]['amt'] != null) {
            $this->invoiceDetails[$index][$field] = $value;

            // Recalculate vatamt if amt or vat field is updated
            if ($field == 'amt' || $field == 'vat' || $field == 'whvat') {
                $amt = $this->invoiceDetails[$index]['amt'] ?? 0;
                $vat = $this->sanitizeNumericValue($this->invoiceDetails[$index]['vat'] ?? 0); // Sanitize vat value
                $whvat = $this->sanitizeNumericValue($this->invoiceDetails[$index]['whvat'] ?? 0); // Sanitize whvat value

                $vatamt = ($amt * $vat) / 100 ?? 0;
                $whtaxamt = ($amt * $whvat) / 100 ?? 0;
                $netamt = $vatamt - $whtaxamt + $amt;

                $this->invoiceDetails[$index]['vatamt'] = $vatamt;
                $this->invoiceDetails[$index]['whtaxamt'] = $whtaxamt;
                $this->invoiceDetails[$index]['netamt'] = $netamt;
            }
        }
        else{
            $this->invoiceDetails[$index]['amt'] = 0;    
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
            'rental' => ['required'],
            'customerCode'  => ['required'],
            'service' => ['required'],
            'psGroup' => ['required'],
       ]); 
        $check = True;
        $customer_rent= CustomerRental::where('customer_id',$this->customerCode)->where('id',$this->rental)->first();
        $product_service = ProductService::where('id',$this->service)->first();
        $ps_group = PsGroup::where('id',$this->psGroup)->first();
        if($ps_group->begin_date == '1' && $ps_group->end_date == '31'){

            $carbon_date = Carbon::parse($this->invoiceDate);

            $start = $carbon_date->copy()->startOfMonth()->format('d/m/Y');
            $end = $carbon_date->copy()->endOfMonth()->format('d/m/Y');
            $period = $start . " - " . $end;
        }
        else{
            $carbon_date = Carbon::parse($this->invoiceDate);
            $period = $carbon_date->copy()->day($ps_group->begin_date)->format('d/m/Y') . " - " . $carbon_date->copy()->addMonth()->day($ps_group->end_date)->format('d/m/Y');
        }
        
        if($product_service->ps_code == "1001"){
            $amt = $customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $product_service->ps_whtax)/100;
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period ?? 0
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$product_service->ps_whtax
            ,'whtaxamt' => $whamt 
            ,'netamt'=>$amt + $vatamt - $whamt
            ,'remark'=>''];
            $check = false;
        }
        if($product_service->ps_code == '1030'){
            $amt = $customer_rent->custr_area_sqm * $customer_rent->custr_service_fee;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $product_service->ps_whtax)/100;
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=>$amt
            ,'vat'=>$product_service->ps_vat
            ,'vatamt'=>$vatamt
            ,'whvat'=>$product_service->ps_whtax
            ,'whtaxamt' => $whamt 
            ,'netamt'=>$amt + $vatamt - $whamt
            ,'remark'=>''];
            $check = false;
        }
        if($check){
             $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'period' => $period
            ,'amt'=> 0
            ,'vat'=> 0
            ,'vatamt'=> 0
             ,'whvat'=> 0
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
            'rental' => ['required'],
            'customerCode'  => ['required'],
            'service' => ['required'],  
        ]);
        $prefix = 'I'.$this->tower.'S';
        $year = Carbon::now()->year + 543;
        $datePart = substr($year,-2) . Carbon::now()->format('m');

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
            'ps_group_id' => $this->psGroup,
            'inv_status' => 'USE',
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
                'invd_net_remark' => $detail['remark'],
                'invd_receipt_flag' => "No",
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
        }
        
    }

    public function openCreateInvoice(){
        $this->showCreateInvoice = true;
    }

    public function closeCreateInvoice(){
        $this->showCreateInvoice = false;
        $this->reset(['psGroup','customerName','customerCode','customerrents','rental','service','invoiceDate','invoiceDetails']);
        $this->resetValidation();
    }

    public function exportPdf($id){
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $invoice = InvoiceHeader::where('id',$id)->with('invoicedetail')->first();
        $data = [
            'invoice' => $invoice
        ];
        $pdf = Pdf::loadView('invoicepdf.invoice3');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'aaa.pdf');
    }

    
    public function render()
    {
        $invoices = InvoiceHeader::with('invoicedetail')->orderBy('id','desc')->get();
        return view('livewire.invoice',compact('invoices'));
    }
}
