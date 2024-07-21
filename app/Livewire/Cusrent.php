<?php

namespace App\Livewire;

use App\Models\CustomerRental;
use Livewire\Component;
use Livewire\WithPagination;

class Cusrent extends Component
{
    use WithPagination;
    public function render()
    {
        $rentals = CustomerRental::paginate(10);
        return view('livewire.cusrent',compact('rentals'));
    }
}
