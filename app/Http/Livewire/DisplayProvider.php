<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;
use App\Models\Services;

class DisplayProvider extends Component
{
    public $serviceProviders;
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

    // Method to retrieve services associated with a specific service provider
    public function viewServices($id)
    {
        // Load services associated with the selected provider ID
        $this->services = Services::where('ProviderId', $id)->get();
        // Set the selected provider ID
        $this->selectedProviderId = $id;
        // Emit an event to open the modal
        $this->emit('openViewServicesModal');
    }

    // Delete a provider and its associated services
    public function deleteProvider($id)
    {
        // Find the ServiceProvider by ID
        ServiceProviders::where('id', $id)->delete();
        // Delete all associated services for the ServiceProvider
        Services::where('ProviderId', $id)->delete();
    }

    // Emit an event when the "Edit" button is clicked
    public function editProvider($providerId)
    {
        $this->emit('editProvider', $providerId);
    }

    public function render()
    {
        return view('livewire.display-provider');
    }
}
