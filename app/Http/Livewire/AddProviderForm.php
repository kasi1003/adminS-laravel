<?php

namespace App\Http\Livewire;

use Livewire\Component;

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
        // Reset serviceNames array based on numberOfServices
        $this->serviceNames = array_fill(0, $index, '');
        $this->serviceDescriptions = array_fill(0, $index, '');
        $this->servicePrices = array_fill(0, $index, '');
        $this->showServiceDescription = array_fill(0, $index, false);
    }

    public function updatedServiceNames($value, $index)
    {
        if (!empty($value)) {
            $this->generateServiceDescriptionField($index);
        }
    }


    public function addProvider()
    {
    }
}
