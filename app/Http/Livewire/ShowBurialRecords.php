<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;


class ShowBurialRecords extends Component
{
    
    public function render()
    {
        // Fetch service providers from the database
        return view('livewire.show-burial-records');
    }
}
