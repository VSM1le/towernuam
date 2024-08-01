<?php

namespace App\Livewire;

use App\Imports\BillImport;
use App\Models\Bill;
use Carbon\Carbon;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BillWE extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $type;
    public $typeQuery = "WA";

    public $monthYear;
    public $showImportModal = false;
    public function bill()
    {
        // Validate the uploaded file
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt,xls,xlsx',
            'type' => 'required',
        ]);

        // Check if the file is set
        if (!$this->csvFile) {
            session()->flash('error', 'No file uploaded');
            return;
        }

        // Store the uploaded file temporarily
        // $filePath = $this->csvFile->store('temp');
        // $fullPath = storage_path('app/' . $filePath);

        // Explicitly specify the file type
        Excel::import(new BillImport($this->type), $this->csvFile);

        // Provide feedback to the user
        session()->flash('success', 'File imported successfully!');
    }
    public function openImport(){
        $this->showImportModal = true;
    }
    public function render()
    {
       $monthYear = $this->monthYear ?? Carbon::now()->format('Y-m');
       $bills = Bill::when($monthYear, function ($query) use($monthYear) {
       $query->where('invoice_date', 'like', '%' . $monthYear  . '%');
       })
       ->when($this->typeQuery, function ($query){
        $query->where('type',$this->typeQuery);
       })
       ->get();
 
        return view('livewire.bill-w-e',['bills'=> $bills]);
    }
}
