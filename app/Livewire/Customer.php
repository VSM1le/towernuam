<?php

namespace App\Livewire;

use App\Models\Customer as ModelsCustomer;
use Livewire\Component;
use Livewire\WithPagination;

class Customer extends Component
{
    use WithPagination;

    public $showCreateCustomer = false;
    public $custCode;
    public $taxId;
    public $customerType;
    public $thName;
    public $enName;
    public $address1;
    public $address2;
    public $zipCode;
    public $branch;
    public $unitCost;
    public $calVat = 'Y';
    public $whTax = 'Y';
    public $autoInv = 'Y';
    
    public $showEditCustomer = false;
    public $editId;

    public function openCreateCustomer(){
        $this->showCreateCustomer = true;
    }

    public function createCustomer(){
        ModelsCustomer::create([
            'cust_code' => $this->custCode,
            'cust_name_th' => $this->thName,
            'cust_name_en' => $this->enName,
            'cust_taxid' => $this->taxId,
            'cust_address_th1' => $this->address1,
            'cust_address_th2' => $this->address2,
            'cust_zipcode' => $this->zipCode,
            'cust_calvat' => $this->calVat,
            'cust_calwhtax' => $this->whTax,
            'cust_invauto' => $this->autoInv,
            'cust_branch' => $this->branch,
            'cust_e_unitcost' => $this->unitCost,
            'cust_gov_flag' => $this->customerType,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);
        $this->closeCreateCustomer();
    }
    public function closeCreateCustomer(){
        $this->resetValidation();
        $this->reset(['custCode','taxId','customerType','thName','enName','address1','address2','zipCode','branch','unitCost']);
        $this->calVat = 'Y';
        $this->whTax = 'Y';
        $this->autoInv = 'Y';
        $this->showCreateCustomer = false;
    }

    public function openEditCustomer($id){
        $this->editId = $id;
        $customer = ModelsCustomer::where('id',$id)->first();
        $this->custCode = $customer->cust_code;
        $this->thName = $customer->cust_name_th;
        $this->enName = $customer->cust_name_en;
        $this->taxId = $customer->cust_taxid;
        $this->address1 = $customer->cust_address_th1;
        $this->address2 = $customer->cust_address_th2;
        $this->zipCode = $customer->cust_zipcode;
        $this->calVat = $customer->cust_calvat;
        $this->whTax = $customer->cust_calwhtax;
        $this->autoInv = $customer->cust_invauto;
        $this->branch = $customer->cust_branch;
        $this->unitCost = $customer->cust_e_unitcost;
        $this->customerType = $customer->cust_gov_flag;

        $this->showEditCustomer = true;
    }

    public function editCustomer(){
        ModelsCustomer::where('id',$this->editId)->update([
            'cust_code' => $this->custCode,
            'cust_name_th' => $this->thName,
            'cust_name_en' => $this->enName,
            'cust_taxid' => $this->taxId,
            'cust_address_th1' => $this->address1,
            'cust_address_th2' => $this->address2,
            'cust_zipcode' => $this->zipCode,
            'cust_calvat' => $this->calVat,
            'cust_calwhtax' => $this->whTax,
            'cust_invauto' => $this->autoInv,
            'cust_branch' => $this->branch,
            'cust_e_unitcost' => $this->unitCost,
            'cust_gov_flag' => $this->customerType,
            'updated_by' => auth()->id(),
        ]);
        $this->closeEditCustomer();
    }

    public function closeEditCustomer(){
        $this->resetValidation();
        $this->reset(['custCode','taxId','customerType','thName','enName','address1','address2','zipCode','branch','unitCost']);
        $this->calVat = 'Y';
        $this->whTax = 'Y';
        $this->autoInv = 'Y';
        $this->showEditCustomer = false;
    }

    public function render()
    {
        $customers = ModelsCustomer::orderBy('cust_code')->paginate(10);
        return view('livewire.customer' , compact('customers'));
    }
}
