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
        dd('Data sent to API:', $data);

        // Make an HTTP POST request to your API endpoint
        $response = Http::post('http://localhost:8000/api/postProvider', $data);

        // Check if the request was successful
        if ($response->successful()) {
            // Optionally, show a success message or perform other actions
            // Reset form fields after successful submission
            $this->resetForm();
        } else {
            // Handle errors if the request was not successful
            // You can log errors, display error messages, etc.
            // For example:
            $errorMessage = $response->json()['message'];
            // You can then display $errorMessage to the user or handle it as needed
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
