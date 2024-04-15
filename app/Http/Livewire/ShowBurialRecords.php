<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;
use App\Models\Graves;



class ShowBurialRecords extends Component
{
    
    public function render()
    {
        // Fetch graves data from the Graves model
        $graves = Graves::all();

        // Pass the fetched data to the view
        return view('livewire.show-burial-records', compact('graves'));
    }
}
