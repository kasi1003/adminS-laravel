<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;
use App\Models\Services;

class DisplayProvider extends Component
{
    public $serviceProviders;
    public $providerId;

    public $selectedProviderId; // Add a property to store the selected provider's ID
    public $services = [];

    public function mount()
    {
        $this->load_data();
    }

    // Load data from the database needed for the form to be populated
    public function load_data()
    {
        $this->serviceProviders = ServiceProviders::all();
    }

    public function viewServices($id)
    {
        // Load services associated with the selected provider ID
        $this->services = Services::where('ProviderId', $id)->get();
        // Set the selected provider ID
        $this->selectedProviderId = $id;
        // Emit an event to open the modal
        $this->emit('openViewServicesModal');
    }




    // Emit an event when the "Edit" button is clicked
    public function editProvider($providerId)
    {
        $this->emit('editProvider', $providerId);
    }
    protected $listeners = ['deleteProvider' => 'deleteProvider'];
    public function deleteConfirm($id)
    {
        $this->providerId = $id;
        $this->dispatchBrowserEvent('confirmDelete');
    }
    public function deleteProvider()
    {
        // Delete logic here
        // Example:
        $ServiceProviders = ServiceProviders::find($this->providerId)->delete();
        Services::where('ProviderId', $this->providerId)->delete();


        if ($ServiceProviders) {
            $this->dispatchBrowserEvent('cemDeleted'); // Dispatch event after deletion
        } else {
            // Handle case where cemetery was not found
        }
    }



    public function render()
    {
        $this->serviceProviders = ServiceProviders::all();
        $this->services = Services::all();

        return view('livewire.display-provider', [
            'serviceProviders' => $this->serviceProviders,
            'services'=>$this->services
        ]);
    }
}