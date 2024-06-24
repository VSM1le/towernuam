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
    public $psGroup;
    public $customerName;
    public $customerCode;
    public $rental;
    public $service;
    public $invoiceDate;

    public $invoiceDetails;

    public function updatedCustomerCode(){
        $this->rental= null;
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
    public function customerrents(){
        return CustomerRental::where('cust_code',$this->customerCode)->get();
    }

    #[Computed()]
    public function productservices(){
        return ProductService::all();
    }

    public function addline(){
        if(!is_null($this->service)){
        $product_service = ProductService::where('ps_code',$this->service)->first();
        $this->invoiceDetails[] = ['pscode'=> $product_service->ps_code,'psname' => $product_service->ps_name_th,'amt'=>'0000','vat'=>$product_service->ps_vat,'vatamt'=>'00.00','whvat'=>$product_service->ps_whtax,'netamt'=>'0000','remark'=>''];
        // dump($this->invoiceDetails);
        }
    }

    public function render()
    {
        return view('livewire.invoice');
    }
}
