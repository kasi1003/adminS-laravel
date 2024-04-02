<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddProviderForm extends Component
{
    public $numberOfServices;
    public $serviceNames = [];
    public $name;
    public $email;
    public $number;
    public $serviceDescriptions =[];
    public $servicePrices;
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
    }
}
