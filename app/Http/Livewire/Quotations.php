<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Orders; // Import the Order model

class Quotations extends Component
{
    public $orders;

    public function mount()
    {
        // Fetch orders from the database when the component is mounted
        $orders = Orders::all();
        
        // Filter the orders to ensure only one entry for each UserId
        $this->orders = $orders->unique('UserId');
    }

    public function render()
    {
        // Pass the orders data to the view
        return view('livewire.quotations', [
            'orders' => $this->orders,
        ]);
    }
}
