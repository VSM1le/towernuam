<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\InvoiceDetail;
use App\Models\InvoiceHeader;
use App\Models\ReceiptHeader;
use App\Models\ReciptDetail;
use App\Services\numberToBath;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Options;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Receipt extends Component
{
    use WithPagination;
    public $receiptDate ;
    public $customerCode = null;

    public $paymentType = "cash";

    public $cheque = ['bank' => "",'branch' => "",'chequeDate' => null,'no' => ""];
    public $invoiceDetails ;
    public $sumCheque = 0; 
    public $disable = true;
    public $tower = "A";
    public $sumWh = 0;

    public $showCreateReceipt = false;

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

    public function updateInvoiceDetails($index,$field){
        
        if ($this->invoiceDetails[$index][$field] == "") {
            $this->invoiceDetails[$index][$field] = 0;
        }
        if($field == 'paid'){
        $this->sumCheque = 0;    
        foreach ($this->invoiceDetails as $detail) {
            $this->sumCheque += $detail['paid'] ?? 0;
        }
        $this->sumCheque = round($this->sumCheque,2);
        }
        else{
            $this->sumWh = 0;
            foreach($this->invoiceDetails as $detail){
                $this->sumWh += $detail[$field] ?? 0;
            }
            $this->sumWh = round($this->sumWh,2);
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
            $this->sumCheque = 0;
            $detail_invoices = InvoiceDetail::with('invoiceheader')->whereNot('invd_receipt_flag','Yes')
            ->whereHas('invoiceheader',function($query){
                $query->where('inv_status','USE')->where('customer_id',$this->customerCode);
            })->get();

            if(!is_null($detail_invoices)){
                foreach($detail_invoices as $detail){
                        $amt = round($detail->invd_net_amt - $detail->invd_wh_tax_amt,2) ?? 0;
                        $whamount = round($detail->invd_wh_tax_amt - ReciptDetail::where('invoice_detail_id',$detail->id)
                        ->whereHas('receiptheader',function ($query){
                            $query->where('rec_status','!=' ,'No');
                        })->sum('whpay') ?? 0,2);
                    $this->invoiceDetails[] = 
                    [
                    'id' => $detail->id,
                    'invdnumber'=> $detail->invoiceheader->inv_no,
                    'contact' => $detail->invoiceheader->customerrental->custr_contract_no ?? null,
                    'procode'=> $detail->invd_product_code,
                    'proname'=> $detail->invd_product_name,
                    'perwh' =>  $detail->invd_wh_tax_percent,
                    'netamt' => $amt,
                    'whtax' => $whamount,
                    'tax' => $detail->invd_vat_amt,
                    'receiptamt' => $detail->invd_receipt_amt ?? 0,
                    'paid' => round($amt - $detail->invd_receipt_amt, 2), 
                    'whpay' =>$whamount, 
                    ];
                    $this->sumCheque +=  $amt - $detail->invd_receipt_amt;
                    $this->sumWh += $whamount;
                }
                $this->sumCheque = round($this->sumCheque,2);
            
            }
        }
    }

    public function removeItem($index)
    {
        unset($this->invoiceDetails[$index]);

        $this->invoiceDetails = array_values($this->invoiceDetails);

        $this->sumCheque = 0;
        foreach ($this->invoiceDetails as $detail) {
            $this->sumCheque += $detail['paid'] ?? 0;
            $this->sumWh += $detail['whpay'] ?? 0;
        }
        $this->sumWh = round($this->sumWh,2);
        $this->sumCheque = round($this->sumCheque,2);
    } 

    public function createReceipt(){
        $this->validate([
            'receiptDate' => ['required', 'date'],
            'customerCode' => ['required'],
            'sumCheque' => ['required', 'numeric', 'min:0'],
            'paymentType' => ['required'],
            'invoiceDetails' => ['required', 'array'],
            'cheque.bank' => ['required_if:paymentType,cheq'],
            'cheque.branch' => ['required_if:paymentType,cheq'],
            'cheque.no' => ['required_if:paymentType,cheq'],
            'cheque.chequeDate' => ['required_if:paymentType,cheq', 'nullable', 'date'],
        ],
        [
            'cheque.bank.required_if' => 'Bank is required.',
            'cheque.no.required_if' => 'Bank No. is required.',
            'cheque.chequeDate.required_if' => 'Cheque Date is required.',
            'cheque.branch.required_if' => 'branch is required.'
        ]);


        $prefix = 'R'.$this->tower.'S';
        $year = Carbon::parse($this->receiptDate)->format("Y");
        $datePart = substr($year,-2) . Carbon::parse($this->receiptDate)->format('m');

        $lastReceipt= ReceiptHeader::where('rec_no', 'like', $prefix . $datePart . '%')->orderBy('rec_no', 'desc')->first();

        if (is_null($lastReceipt)) {
            $recNo = $prefix . $datePart . '0001';
        } else {
            $lastNumber = (int)substr($lastReceipt->rec_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $recNo = $prefix . $datePart . $newNumber;
        }

        $create_receipt = ReceiptHeader::create([
            'rec_no' => $recNo,
            'customer_id' => $this->customerCode,
            'rec_date' => $this->receiptDate,
            'rec_status' => "Yes",
            'rec_payment_amt' => $this->sumCheque,
            'rec_payment_type' => $this->paymentType,
            'rec_bank' => $this->cheque['bank'] ?? null,
            'rec_branch' => $this->cheque['branch'] ?? null,
            'rec_cheque_no' => $this->cheque['no'] ?? null,
            'rec_cheque_date' => $this->cheque['chequeDate'] ?? null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        foreach ($this->invoiceDetails as $detail) {
            $flag = ($detail['netamt'] <= $detail['paid'] + $detail['receiptamt']) ? "Yes" : "Partial";
            InvoiceDetail::where('id', $detail['id'])->update([
                "invd_receipt_flag" => $flag,
                "invd_receipt_amt" =>round($detail['receiptamt'] +  $detail['paid'],2),
            ]);

                $create_receipt->receiptdetail()->create([
                    'invoice_detail_id' => $detail['id'],
                    'rec_pay' =>  $detail['paid'],
                    'whpay' => $detail['whpay'], 
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            
        } 
        $this->closeCreateReceipt();
        return redirect()->route('receipt');
    }

    public function openCreateReceipt(){
        $this->showCreateReceipt = true;
    }

     public function closeCreateReceipt(){
        $this->showCreateReceipt = false;
        $this->receiptDate = null;
        $this->customerCode = null;
        $this->paymentType = "cash";
        $this->cheque = ['bank' => "", 'branch' => "", 'chequeDate' => null, 'no' => ""];
        $this->invoiceDetails = [];
        $this->sumCheque = 0;
        $this->resetValidation();
       
    }
    public function exportPdf($id){
        $number = new numberToBath;
        $sum = 0; 
        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isRemoteEnabled', true);
        $receipt= ReceiptHeader::where('id',$id)->with(['receiptdetail','customer'])->first();
        $receiptDetails = $receipt->receiptdetail->map(function ($detail){
        $detail->calculated_vat = round(($detail->rec_pay * $detail->invoicedetail->invd_vat_percent) / 100,2);
        $detail->gross = round($detail->rec_pay - ($detail->rec_pay * $detail->invoicedetail->invd_vat_percent / 100),2);
        $detail->whtax = round(($detail->rec_pay * $detail->invoicedetail->invd_wh_tax_percent) / 100 , 2);
        return $detail;
        });
        $bath = $number->baht_text($receipt->rec_payment_amt);
        $html1 = view('invoicepdf.invoice1', ['Receipt' => $receipt,'receiptdetails' => $receiptDetails,'bath' => $bath]);
        $html2 = view('invoicepdf.invoice2', ['Receipt' => $receipt,'receiptdetails' => $receiptDetails,'bath' => $bath]);
        // $html2 = view('invoicepdf.invoice3', ['Invoices' => $invoice, 'bath' => $bath])->render();
        
        $combinedHtml = $html1 . $html2; 
        $pdf = PDF::loadHTML($combinedHtml);
       return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $receipt->rec_no . '.pdf'); 
    } 

    public function render()
    {
        $receipt = ReceiptHeader::with(['customer','receiptdetail'])->orderBy('rec_no','desc')->paginate(10);
        return view('livewire.receipt', compact('receipt'));
    }
}
