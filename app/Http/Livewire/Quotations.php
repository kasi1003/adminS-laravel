<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Orders;

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

    public function generatePdf($userId)
{
    // Redirect to the route that handles PDF generation
    return redirect()->route('generate-pdf', ['userId' => $userId]);
}

public function approveOrder($userId)
    {
        // Delete orders associated with the given UserId
        Orders::where('UserId', $userId)->delete();

        // Fetch updated orders from the database
        $orders = Orders::all();

        // Filter the orders to ensure only one entry for each UserId
        $this->orders = $orders->unique('UserId');

        // Show a success message
        session()->flash('message', 'Order approved successfully.');
    }

}
