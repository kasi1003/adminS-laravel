<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ServiceProviders;


class AddProviderForm extends Component
{
    public $name;
    public $motto;
    public $email;
    public $cellphoneNumber;
    public $numberOfServices;
    public $serviceNames = [];

    public $serviceDescriptions = [];
    public $servicePrices = [];

    public $showServiceDescription = [];
    public $isEditing;
    public $provider;








    public function render()
    {


        return view('livewire.add-provider-form');
    }
    public function generateServiceDescriptionField($index)
    {
        $this->showServiceDescription[$index] = true;
    }
    public function updatedServiceNames($value, $index)
    {
        if (!empty($value)) {
            $this->generateServiceDescriptionField($index);
        }
    }

    public function postProvider()
    {
        $data = [
            'name' => $this->name,
            'motto' => $this->motto,
            'email' => $this->email,
            'cellphoneNumber' => $this->cellphoneNumber,
            'numberOfServices' => $this->numberOfServices,
            'serviceNames' => $this->serviceNames,
            'serviceDescriptions' => $this->serviceDescriptions,
            'servicePrices' => $this->servicePrices,
        ];
        // Make an HTTP POST request to your API endpoint
        $response = Http::post('http://localhost:8000/api/postProvider', $data);

        // Check if the request was successful
        if ($response->successful()) {
            // Optionally, show a success message or perform other actions
            $this->resetForm();
        } else {
            // Display a generic error message to the user
            session()->flash('error', 'Failed to submit the form. Please try again later.');
        }
    }
    protected $listeners = ['editProvider'];

    public $providerId; // Property to store the provider ID being edited

    public function editProvider($providerId)
    {
        $this->providerId = $providerId;
        $this->isEditing = true; // Set the form to edit mode
        // Fetch the data of the selected provider using its ID
        $this->provider = ServiceProviders::findOrFail($providerId);
        // Populate the form fields with the retrieved data
        $this->name = $this->provider->Name;
        $this->motto = $this->provider->Motto;
        $this->email = $this->provider->Email;
        $this->cellphoneNumber = $this->provider->ContactNumber;
        // You might also need to load and populate services associated with this provider
        // You can emit another event to trigger this if necessary
        // Fetch the count of services associated with the provider
        $this->numberOfServices = $this->provider->services ? count($this->provider->services) : 0;
    }


    public function editProviderApi()
    {
        $data = [
            'name' => $this->name,
            'motto' => $this->motto,
            'email' => $this->email,
            'cellphoneNumber' => $this->cellphoneNumber,
            'numberOfServices' => $this->numberOfServices,
            'serviceNames' => $this->serviceNames,
            'serviceDescriptions' => $this->serviceDescriptions,
            'servicePrices' => $this->servicePrices,
        ];

        // Make an HTTP PUT request to the edit API endpoint with the provider ID
        $response = Http::put('http://localhost:8000/api/editProvider/' . $this->providerId, $data);

        // Check if the request was successful
        if ($response->successful()) {
            // Optionally, show a success message or perform other actions
            $this->resetForm();
        } else {
            // Display a generic error message to the user
            session()->flash('error', 'Failed to update the provider. Please try again later.');
        }
    }

    public function addProvider()
    {

        if ($this->isEditing) {
            // If in edit mode, trigger the edit API
            $this->editProviderApi();
        } else {
            // If not in edit mode, trigger the add API
            $this->postProvider();
        }
    }

    private function resetForm()
    {
        // Reset form fields after successful submission
        $this->name = '';
        $this->motto = '';
        $this->email = '';
        $this->cellphoneNumber = '';
        $this->numberOfServices = '';
        $this->serviceNames = [];
        $this->serviceDescriptions = [];
        $this->servicePrices = [];
    }
}
