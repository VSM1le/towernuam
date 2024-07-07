<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\InvoiceDetail;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Receipt extends Component
{
    public $receiptDate = null;
    public $customerCode = null;
    public $invoiceDetails ; 

     #[Computed()]
    public function customers(){
        return Customer::all();
    }

    public function updatedCustomerCode() {
        $this->invoiceDetails = null;
        if(!is_null($this->customerCode)){
            $detail_invoices = InvoiceDetail::with('invoiceheader')->whereNot('invd_receipt_flag','Yes')
            ->whereHas('invoiceheader',function($query){
                $query->where('inv_status','USE')->where('customer_id',$this->customerCode);
            })->get();

            if(!is_null($detail_invoices)){
                foreach($detail_invoices as $detail){
                    $this->invoiceDetails[] = 
                    [
                    'id' => $detail->id,
                    'invdnumber'=> $detail->invoiceheader->inv_no,
                    'contact' => $detail->invoiceheader->customerrental->custr_contract_no ?? null,
                    'procode'=> $detail->invd_product_code,
                    'proname'=> $detail->invd_product_name,
                    'netamt' => $detail->invd_net_amt,
                    'tax' => $detail->invd_vat_amt,
                    'whtax' => $detail->invd_wh_tax_amt,
                    'receiptamt' => $detail->invd_receipt_amt ?? 0,
                    'paid' => ''
                ];
                }
                dump($this->invoiceDetails);
            }
        }
    }

    public function render()
    {
        return view('livewire.receipt');
    }
}
