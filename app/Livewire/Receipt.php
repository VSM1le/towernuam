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
    public $paymentType = "cash";
    public $bank = null;
    public $branch = null;
    public $no = null;
    public $chequeDate = null;
    public $invoiceDetails ;
    public $sumCheque = 0; 
    public $disable = true;
     #[Computed()]
    public function customers(){
        return Customer::all();
    }

    public function updatedPaymenttype($value){
        if ($value === 'cheq') {
            // If the value is 'cheq', enable the input field
            $this->disable = false;
        } else {
            // If the value is not 'cheq', disable the input field
            $this->disable = true;
        }
        $this->bank = null;
        $this->branch = null;
        $this->no = null;
        $this->chequeDate = null;
    }

    public function updateInvoiceDetails($index){
        if($this->invoiceDetails[$index]['paid'] == ""){
            $this->invoiceDetails[$index]['paid'] = 0;
        }
        $this->sumCheque = $this->sumCheque + $this->invoiceDetails[$index]['paid'] ?? 0;
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
                    'paid' => 0
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
