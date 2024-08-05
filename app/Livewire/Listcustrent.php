<?php

namespace App\Livewire;

use App\Models\CustomerRental;
use Livewire\Attributes\Url;
use Livewire\Component;

class Listcustrent extends Component
{
    public $conId;
    public $contractInfo;
    public function mount($id){
        $this->conId = $id;
        $this->contractInfo = CustomerRental::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.listcustrent');
    }
}
