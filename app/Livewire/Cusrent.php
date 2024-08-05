<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\CustomerRental;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Cusrent extends Component
{
    use WithPagination;

    public $customerId;
    public $contractNumber;
    public $contractRNumber;
    public $startDate;
    public $endDate;
    public $year;
    public $unit;
    public $areaSqm;
    public $rentalFee;
    public $serviceFee;
    public $equipFee;
    public $tower = "A";

    public $showCreateContract = false;

    public $showEditContract = false;
    public $editId;

     #[Computed()]
    public function customers(){
        return Customer::all();
    }
    public function openCreateContract(){
        $this->showCreateContract = true;
    }
    public function createContract(){
        CustomerRental::create([
            'customer_id' => $this->customerId,
            'custr_no' => 1,
            'custr_contract_no' => $this->contractNumber,
            'custr_contract_no_real' => $this->contractRNumber,
            'custr_tower' => $this->tower,
            'custr_unit' => $this->unit,
            'custr_area_sqm' => $this->areaSqm,
            'custr_rental_fee' => $this->rentalFee,
            'custr_service_fee' => $this->serviceFee,
            'custr_equipment_fee' => $this->equipFee,
            'custr_begin_date2' => $this->startDate,
            'custr_end_date2' => $this->endDate,
            'custr_contract_year' => $this->year,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
        $this->closeCreateContract();
    }
    public function closeCreateContract(){
        $this->showCreateContract = false;
        $this->reset(['contractNumber','contractRNumber','customerId','unit','areaSqm','rentalFee','serviceFee','equipFee','startDate','endDate','year']);
    }

    public function openEditContract($id){
     
        $this->editId = $id;
        $contract = CustomerRental::where('id',$id)->first();
        $this->customerId = $contract->customer_id;
        $this->contractNumber = $contract->custr_contract_no;
        $this->contractRNumber = $contract->custr_contract_no_real; 
        $this->unit = $contract->custr_unit;
        $this->areaSqm = $contract->custr_area_sqm;
        $this->rentalFee = $contract->custr_service_fee;
        $this->serviceFee = $contract->custr_service_fee;
        $this->equipFee = $contract->custr_equipment_fee;
        $this->startDate = $contract->custr_begin_date2;
        $this->endDate = $contract->custr_end_date2;
        $this->year = $contract->custr_contract_year;
        $this->showEditContract = true;
    } 

    public function editContract(){
        CustomerRental::where('id',$this->editId)->update([
            'customer_id' => $this->customerId,
            'custr_contract_no' => $this->contractNumber,
            'custr_contract_no_real' => $this->contractRNumber,
            'custr_tower' => $this->tower,
            'custr_unit' => $this->unit,
            'custr_area_sqm' => $this->areaSqm,
            'custr_rental_fee' => $this->rentalFee,
            'custr_service_fee' => $this->serviceFee,
            'custr_equipment_fee' => $this->equipFee,
            'custr_begin_date2' => $this->startDate,
            'custr_end_date2' => $this->endDate,
            'custr_contract_year' => $this->year,
            'updated_by' => auth()->id(),
        ]);
        $this->closeEditContract();
    }

    public function closeEditContract(){
        $this->reset(['contractNumber','contractRNumber','customerId','unit','areaSqm','rentalFee','serviceFee','equipFee','startDate','endDate','year','editId']);
        $this->showEditContract = false;
    }

    public function render()
    {
        $rentals = CustomerRental::orderBy('updated_at','desc')->paginate(10);
        return view('livewire.cusrent',compact('rentals'));
    }
}
