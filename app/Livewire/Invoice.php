<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerRental;
use App\Models\ProductService;
use App\Models\PsGroup;
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

    public function updatedCustomerCode(){
        $this->rental = null;
        $this->invoiceDetails = null;
          if (!is_null($this->customerCode)) {
            $this->customerrents = CustomerRental::where('customer_id',$this->customerCode)->get();
        } else {
            $this->customerrents = null;    
        }
        
    }

    public function updateInvoiceDetail($index, $field)
{
    if (isset($this->invoiceDetails[$index])) {
        // Recalculate vatamt if amt or vat field is updated
        if ($field == 'amt' || $field == 'vat' || $field == 'whvat') {
            $vatamt = ($this->invoiceDetails[$index]['amt'] * $this->invoiceDetails[$index]['vat']) / 100;
            $this->invoiceDetails[$index]['whtaxamt'] = ($this->invoiceDetails[$index]['amt'] * $this->invoiceDetails[$index]['whvat']) / 100;
            $this->invoiceDetails[$index]['vatamt'] = $vatamt; 
            $this->invoiceDetails[$index]['netamt'] = $vatamt - $this->invoiceDetails[$index]['whtaxamt']+ $this->invoiceDetails[$index]['amt'];
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
            'rental' => ['required'],
            'customerCode'  => ['required'],
            'service' => ['required'],
       ]); 
        $check = True;
        $customer_rent= CustomerRental::where('customer_id',$this->customerCode)->where('id',$this->rental)->first();
        $product_service = ProductService::where('id',$this->service)->first();
        if($product_service->ps_code == "1001"){
            $amt = $customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm;
            $vatamt = ($amt * $product_service->ps_vat)/100;
            $whamt = ($amt * $product_service->ps_whtax)/100;
            $this->invoiceDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
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
            ,'amt'=> 0
            ,'vat'=> 0
            ,'vatamt'=> 0
             ,'whvat'=> 0
            ,'whtaxamt' => 0
            ,'netamt'=> 0
            ,'remark'=>''];
        }
    }

    public function render()
    {
        return view('livewire.invoice');
    }
}
