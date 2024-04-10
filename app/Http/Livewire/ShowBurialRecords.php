<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;


class ShowBurialRecords extends Component
{
    public $serviceProviders;
    
    public function mount()
    {
        $this->load_data();
    }
    
    //here we will load the data from the db needed for the form to be populated
    public function load_data()
    {
        $this->serviceProviders = ServiceProviders::all();
      
    }
    public function render()
    {
        // Fetch service providers from the database
        return view('livewire.show-burial-records');
    }
}
