<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;
use Illuminate\Support\Facades\Http;



class DisplayProvider extends Component
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
    public function deleteProvider($id)
    {
        try {
            // Make HTTP DELETE request to your API endpoint
            $response = Http::delete('http://localhost:8000/api/deleteProvider/' . $id);

            if ($response->successful()) {
                // Redirect to the named route
                return redirect()->route('serviceProviders');
            } else {
                // Handle error response
                session()->flash('error', 'Failed to delete service provider.');
            }
        } catch (\Exception $e) {
            // Handle exception
            session()->flash('error', 'Failed to delete service provider: ' . $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.display-provider');
    }
}
