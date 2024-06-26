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
            $this->customerrents = CustomerRental::where('id',$this->customerCode)->get();
        } else {
            $this->customerrents = null;    
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
        if(!is_null($this->service)){
        $customer_rent= CustomerRental::where('customer_id',$this->customerCode)->where('id',$this->rental)->first();
        $product_service = ProductService::where('ps_code',$this->service)->first();
        $amt = $customer_rent->custr_rental_fee * $customer_rent->custr_area_sqm;
        $vatamt = ($amt * $product_service->ps_vat)/100;
        $this->invoiceDetails[] = ['pscode'=> $product_service->ps_code,'psname' => $product_service->ps_name_th,'amt'=>$amt,'vat'=>$product_service->ps_vat,'vatamt'=>$vatamt,'whvat'=>$product_service->ps_whtax,'netamt'=>$amt + $vatamt,'remark'=>''];
        }
    }

    public function render()
    {
        return view('livewire.invoice');
    }
}
