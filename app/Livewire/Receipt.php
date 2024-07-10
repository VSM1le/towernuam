<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\InvoiceDetail;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class Receipt extends Component
{
    public $receiptDate = null;
    public $customerCode = null;

    public $paymentType = "cash";

    public $cheque = ['bank' => "",'branch' => "",'chequeDate' => " ",'no' => ""];
    public $invoiceDetails ;
    public $sumCheque = 0; 
    public $disable = true;
    public $checkWh = false;

     #[Computed()]
    public function customers(){
        return Customer::all();
    }

  public function updateCheque($field)
    {
        if ($this->paymentType !== "cheq") {
            $this->cheque[$field] = null;
        }
    } 

    public function updateInvoiceDetails($index){
        if($this->invoiceDetails[$index]['paid'] == ""){
            $this->invoiceDetails[$index]['paid'] = 0;
        }
        $this->sumCheque = $this->sumCheque + $this->invoiceDetails[$index]['paid'] ?? 0;
    }

    public function updatedCheckWh(){
        if($this->invoiceDetails){
            if($this->checkWh){
                foreach($this->invoiceDetails as $index => $detail){
                    $this->invoiceDetails[$index]['netamt'] += $this->invoiceDetails[$index]['whtax'];
                }
            }
            else{
                foreach($this->invoiceDetails as $index => $detail){
                    $this->invoiceDetails[$index]['netamt'] -= $this->invoiceDetails[$index]['whtax'];
                }
            }
        }
    }

     public function updatedPaymentType()
    {
        if ($this->paymentType!== 'cheq') {
            foreach ($this->cheque as $key => $value) {
                $this->cheque[$key] = null;
            }
        }
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
                    $amt = $detail->invd_net_amt;
                    if($this->checkWh == true){
                        $amt = $detail->invd_net_amt - $detail->invd_wh_tax_amt ?? 0;
                    }
                    $this->invoiceDetails[] = 
                    [
                    'id' => $detail->id,
                    'invdnumber'=> $detail->invoiceheader->inv_no,
                    'contact' => $detail->invoiceheader->customerrental->custr_contract_no ?? null,
                    'procode'=> $detail->invd_product_code,
                    'proname'=> $detail->invd_product_name,
                    'netamt' => $amt,
                    'whtax' => $detail->invd_wh_tax_amt,
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

     public function removeItem($index){
       unset($this->invoiceDetails[$index]);
       $this->invoiceDetails = array_values($this->invoiceDetails);
    }

    public function render()
    {
        return view('livewire.receipt');
    }
}
