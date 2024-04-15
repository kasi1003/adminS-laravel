<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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


    public function addProvider()
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
