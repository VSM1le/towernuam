<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\InvoiceDetail;
use App\Models\InvoiceHeader;
use App\Models\ReceiptHeader;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
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
    public $tower = "A";

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
                        $amt = $detail->invd_net_amt - $detail->invd_wh_tax_amt ?? 0;
                    $this->invoiceDetails[] = 
                    [
                    'id' => $detail->id,
                    'invdnumber'=> $detail->invoiceheader->inv_no,
                    'contact' => $detail->invoiceheader->customerrental->custr_contract_no ?? null,
                    'procode'=> $detail->invd_product_code,
                    'proname'=> $detail->invd_product_name,
                    'perwh' =>  $detail->invd_wh_tax_percent,
                    'netamt' => number_format((float)$amt, 2, '.', '') ,
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

    public function createReceipt(){


        $prefix = 'R'.$this->tower.'S';
        $year = Carbon::parse($this->receiptDate)->format("Y");
        $datePart = substr($year,-2) . Carbon::parse($this->receiptDate)->format('m');

        $lastInvoice = ReceiptHeader::where('rec_no', 'like', $prefix . $datePart . '%')->orderBy('rec_no', 'desc')->first();

        if (is_null($lastInvoice)) {
            $recNo = $prefix . $datePart . '0001';
        } else {
            $lastNumber = (int)substr($lastInvoice->inv_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $recNo = $prefix . $datePart . $newNumber;
        }

        $create_receipt = InvoiceHeader::create([

        ]) ;
        foreach($this->invoiceDetails as $detail){
            $flag = "Pati";
            if($detail['netamt'] <= $detail['paid'] )
            {
                $flag = "Yes";
            }
            InvoiceDetail::where('id',$detail['id'])->update([
                "invd_receipt_flag" => $flag,
                "invd_invd_receipt_amt" => $detail['paid']
            ]);
            
        }
    }

    public function render()
    {
        return view('livewire.receipt');
    }
}
