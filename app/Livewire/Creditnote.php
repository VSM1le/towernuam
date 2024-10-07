<?php

namespace App\Livewire;

use App\Models\CreditnoteHeader;
use App\Models\Customer;
use App\Models\CustomerRental;
use App\Models\ProductService;
use App\Services\numberToBath;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Node\Stmt\Catch_;

class Creditnote extends Component
{
    use WithPagination;
    public $showCreateCredit = false;
    public $rental;
    public $creditDetails;
    public $customerrents;
    public $customerCode;
    public $creditDate;
    public $service;
    public $receiptDate;
    public $receiptNumber;
    public $startDate;
    public $endDate;
    public $showDeleteCreditNote = false;
    public $showExportCreditNote = false;
    public $creditId;
    public $creditRemark;
    public $exFromDate;
    public $exToDate;
    public $statusCredit;

    #[Computed()]
    public function customers(){
        return Customer::orderBy('cust_code')->get();
    }
     #[Computed()]
    public function productservices(){
        return ProductService::get();
    }
    public function updatedCustomerCode(){
        $this->rental = null;
        $this->creditDetails = [];
          if (!is_null($this->customerCode)) {
            $this->customerrents = CustomerRental::where('customer_id',$this->customerCode)->get();
        } else {
            $this->customerrents = null;    
        }
    } 
    public function addline(){
       $this->validate([
            'creditDate' => ['required','date'],
            'customerCode'  => ['required'],
            'service' => ['required'],
            'receiptDate' => ['required','date'],
            'receiptNumber' => ['required'],
       ]); 
        $product_service = ProductService::where('id',$this->service)->first();
            $this->creditDetails[] = 
            ['pscode'=> $product_service->ps_code
            ,'psname' => $product_service->ps_name_th
            ,'amt'=> 0 
            ,'vatamt'=> 0 
            ,'whtaxamt' => 0 
            ,'netamt'=> 0
            ,'remark'=> null];
    }


    public function openCreateCreditNoteNoReceipt(){
        $this->showCreateCredit = true;
    }
    public  function closeCreateCreditNoteNoReceipt(){
        $this->showCreateCredit = false;
        $this->reset(['creditDate','customerCode','service','receiptDate','receiptNumber']); 
        $this->creditDetails = [];
        $this->resetValidation();
    } 
    public function createCreditnoteNoReceipt(){
        $this->validate([
            'creditDate' => ['required','date'],
            'customerCode'  => ['required'],
            'service' => ['required'],
            'receiptDate' => ['required','date'],
            'receiptNumber' => ['required'],
        ]);
        $prefix = 'CAS';
        $year = Carbon::parse($this->creditDate)->format('Y');
        $datePart = substr($year,-2) . Carbon::parse($this->creditDate)->format('m');
        $unite = CustomerRental::where('id',$this->rental)->first();
        $lastCredit = CreditnoteHeader::where('credit_no', 'like', $prefix . $datePart . '%')
            ->orderBy('credit_no', 'desc')->first();

        if (is_null($lastCredit)) {
            $creditNo = $prefix . $datePart . '0001';
        } else {
            $lastNumber = (int)substr($lastCredit->credit_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $creditNo = $prefix . $datePart . $newNumber;
        }
        try{
            $creditNote = CreditnoteHeader::create([
                'credit_no' => $creditNo,
                'credit_date' => $this->creditDate,
                'customer_id' => $this->customerCode,
                'customer_rental_id' => $this->rental,
                'credit_room_num' => $unite->custr_unit ?? null,
                'credit_receipt_num' => trim($this->receiptNumber),
                'credit_receipt_date' => $this->receiptDate,
                'credit_status' => true,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);
            foreach($this->creditDetails as $detail){
                $creditNote->creditdetail()->create([
                    'crd_service_code' => $detail['pscode'],
                    'crd_service_name' => $detail['psname'],
                    'crd_amt' => $detail['amt'],
                    'crd_tax_amt' => $detail['vatamt'],
                    'crd_wh_amt' => $detail['whtaxamt'],
                    'crd_net_amt' => $detail['netamt'],
                    'crd_remark' => $detail['remark'],
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            }
            session()->flash('success','Create creditnote succesfully.');
        }catch(\Exception $e){
            session()->flash('error','Something went wrong.');
        }finally{
            $this->closeCreateCreditNoteNoReceipt();
        }
    }
    public function exportCreditNote($id){
        $number = new numberToBath;
        $creditNote = CreditnoteHeader::findOrFail($id);
        $combinedHtml = null;
        if(is_null($creditNote->receipt_header_id)){
            $bath = $number->numberToWords($creditNote->creditdetail->pluck('crd_net_amt')->sum());
            $creditNoteDetails = $creditNote->creditdetail->chunk(6);
            $countPage = count($creditNoteDetails);
            foreach($creditNoteDetails as $index => $detail){
                $html1 = view('invoicepdf.creditnoteeng1', 
                ['creditNote' => $creditNote,
                'creditNoteDetails' => $detail,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath])->render();
                $combinedHtml .=  $html1;
            }
            foreach($creditNoteDetails as $index => $detail){
                $html1 = view('invoicepdf.creditnoteeng2', 
                ['creditNote' => $creditNote,
                'creditNoteDetails' => $detail,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath])->render();
                $combinedHtml .=  $html1;
            }
            $pdf = Pdf::loadHTML($combinedHtml);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $creditNote->credit_no . '.pdf'); 
        }
    }
    public function exportCreditNoteTH($id){
        $number = new numberToBath;
        $creditNote = CreditnoteHeader::findOrFail($id);
        $combinedHtml = null;
        if(is_null($creditNote->receipt_header_id)){
            $bath = $number->baht_text($creditNote->creditdetail->pluck('crd_net_amt')->sum());
            $creditNoteDetails = $creditNote->creditdetail->chunk(6);
            $countPage = count($creditNoteDetails);
            foreach($creditNoteDetails as $index => $detail){
                $html1 = view('invoicepdf.creditnoteth1', 
                ['creditNote' => $creditNote,
                'creditNoteDetails' => $detail,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath])->render();
                $combinedHtml .=  $html1;
            }
            foreach($creditNoteDetails as $index => $detail){
                $html1 = view('invoicepdf.creditnoteth2', 
                ['creditNote' => $creditNote,
                'creditNoteDetails' => $detail,
                'currentPage' => $index + 1,
                'sumPage' => $countPage,
                'bath' => $bath])->render();
                $combinedHtml .=  $html1;
            }
            $pdf = Pdf::loadHTML($combinedHtml);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $creditNote->credit_no . '.pdf'); 
        }
    }
    public function showCancelCreditNote($id){
        $this->showDeleteCreditNote = true;
        $this->creditId = $id;
    } 
    public function cancelCreditNote(){
        try{
            CreditnoteHeader::where('id',$this->creditId)->update([
                'credit_status' => false,
                'credit_remark' => $this->creditRemark ?? null
            ]);
            session()->flash('success','Cancel creditnote successful.');
        }catch(\Exception $e){
            session()->flash('error','Something went wrong can note cancel creditnote.');
        }finally{
            $this->closeCancelCreditNote();
        }
    }

    public function closeCancelCreditNote(){
        $this->showDeleteCreditNote = false;
        $this->reset('creditId','creditRemark');
    }
    public function showExportCreditNote(){
        $this->showExportCreditNote = true;
    }

    public function exportCreditNoteReport(){
         $this->validate([
            'exFromDate' => ['required','date'],
            'exToDate' => ['required','date','after:exFromDate'],
        ],
        [
            'exToDate.after' => "The TO DATE field must be a date after FROM DATE"
        ]);
        $creditNotes = CreditnoteHeader::with("creditdetail")
            ->when($this->exFromDate, function ($query) {
                $query->whereDate('credit_date','>=', $this->exFromDate);
            })
            ->when($this->exToDate, function($query){
                $query->whereDate('credit_date',"<=" ,$this->exToDate);
            })
            ->get();
        $html1 = view('invoicepdf.creditnotereport', 
                [
                'creditNotes' => $creditNotes,
                'dateFrom' => Carbon::parse($this->exFromDate)->format('d-m-Y'),
                'dateTo' => Carbon::parse($this->exToDate)->format('d-m-Y'),
                ])->render();
        $pdf = Pdf::loadHTML($html1);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'credit_report'. '.pdf'); 
    }

    public function closeExportCreditNote(){
        $this->showExportCreditNote = false;
    }

    public function render()
    {
        $creditNotes = CreditnoteHeader::
        when($this->startDate, function ($query) {
            $query->whereDate('credit_date','>=', $this->startDate);
        })
        ->when($this->endDate, function($query){
            $query->whereDate('credit_date',"<=" ,$this->endDate);
        })
        ->when($this->statusCredit != "",function($query){
            $query->where("credit_status", $this->statusCredit);
        })
        ->orderByDesc('credit_no')
        ->paginate(10);
        return view('livewire.creditnote',compact('creditNotes'));
    }
}
