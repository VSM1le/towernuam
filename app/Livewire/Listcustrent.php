<?php

namespace App\Livewire;

use App\Models\CustomerRental;
use App\Models\ListCustomerRent;
use App\Models\ProductService;
use Livewire\Attributes\Url;
use Livewire\Component;

class Listcustrent extends Component
{
    public $conId;
    public $contractInfo;
    public $showCreateList = false;
    public $remark;
    public $productId;
    public $areaSqm;
    public $rentalFee;
    public $serviceFee;
    public $equipFee;
    public $showEditList = false;
    public $listId;
    public $showDeleteList = false;

    public function mount($id){
        $this->conId = $id;
        $this->contractInfo = CustomerRental::findOrFail($id);
    }
    public function openCreateList(){
        $this->showCreateList = true;
    }
    public function closeCreateList(){
        $this->showCreateList = false;
        $this->reset('productId','remark','areaSqm','rentalFee','serviceFee','equipFee');
    }
    public function createList(){
        $this->validate([
            'productId'=> ['required'],
            'areaSqm' => ['required','numeric','min:1'],
            'rentalFee' => ['required','numeric','min:1'],
        ]);

        ListCustomerRent::create([
            'customer_rental_id' => $this->conId,
            'product_service_id' =>  $this->productId,
            'lcr_remark' => $this->remark,
            'lcr_area_sqm' => $this->areaSqm,
            'lcr_rental_fee' => $this->rentalFee,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id()
        ]);
        $this->closeCreateList();

    }
    public function openEditList($id){
        $this->listId = $id;
        $listrent = ListCustomerRent::find($id);
        $this->productId = $listrent->product_service_id;
        $this->remark = $listrent->lcr_remark;
        $this->areaSqm = $listrent->lcr_area_sqm;
        $this->rentalFee = $listrent->lcr_rental_fee;
        $this->showEditList = true;
    }
    public function editList(){
        $this->validate([
            'productId'=> ['required'],
            'areaSqm' => ['required','numeric','min:1'],
            'rentalFee' => ['required','numeric','min:1'],
        ]);
        ListCustomerRent::where('id',$this->listId)->update([
            'product_service_id' =>  $this->productId,
            'lcr_remark' => $this->remark,
            'lcr_area_sqm' => $this->areaSqm,
            'lcr_rental_fee' => $this->rentalFee,
            'updated_by' => auth()->id()
        ]);
        $this->closeEditList();
    }
    public function closeEditList(){
        $this->showEditList = false;
       $this->reset('productId','remark','areaSqm','rentalFee','serviceFee','equipFee','listId'); 
    }
    public function openDeleteList($id)
    {
        $this->listId = $id;
        $this->showDeleteList = true;
    }
    public function deleteList(){
        ListCustomerRent::where('id',$this->listId)->delete();
        $this->closeDeleteList();
    }
    public function closeDeleteList(){
        $this->showDeleteList = false;
        $this->reset('listId');
    }
    public function render()
    {
        $products = ProductService::where('ps_group_id',1)
            ->orWhere('ps_group_id',4)
            ->orWhere('ps_group_id',6)
            ->get();
        $rentLists = ListCustomerRent::where('customer_rental_id',$this->conId)->get();
        return view('livewire.listcustrent',compact('products','rentLists'));
    }
}
