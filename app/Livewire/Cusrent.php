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
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
    }
    public function closeCreateContract(){
        $this->showCreateContract = false;
        $this->reset(['contractNumber','contractrNumber','customerId','unit','areaSqm','rentalFee','serviceFee','equipFee','startDate','endDate','year']);
    }

    public function openEditContract($id){
     
        $this->editId = $id;
        $contract = CustomerRental::where('id',$id)->get();
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
    
        $this->showEditContract = true;
    } 

    public function editContract(){
        CustomerRental::where('id',$this->editId)->update([
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
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
    }

    public function closeEditContract(){
        $this->reset(['contractNumber','contractrNumber','customerId','unit','areaSqm','rentalFee','serviceFee','equipFee','startDate','endDate','year','editId']);
        $this->showEditContract = false;
    }

    public function render()
    {
        $rentals = CustomerRental::paginate(10);
        return view('livewire.cusrent',compact('rentals'));
    }
}
