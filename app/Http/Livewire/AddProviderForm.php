<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceProviders;
use App\Models\Services;
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
        $validatedData = [
            'name' => $this->name,
            'motto' => $this->motto,
            'email' => $this->email,
            'cellphoneNumber' => $this->cellphoneNumber,
            'numberOfServices' => $this->numberOfServices,
            'serviceNames' => $this->serviceNames,
            'serviceDescriptions' => $this->serviceDescriptions,
            'servicePrices' => $this->servicePrices,
        ];
         // Start a database transaction
         DB::beginTransaction();

         try {
             // Create a new instance of the ServiceProviders model and fill it with validated data
             $provider = ServiceProviders::create([
                 'Name' => $validatedData['name'],
                 'Motto' => $validatedData['motto'],
                 'Email' => $validatedData['email'],
                 'ContactNumber' => $validatedData['cellphoneNumber'],
                 // Add other model attributes here
             ]);
 
             // Prepare data for bulk insertion of services
             $servicesData = [];
             for ($i = 0; $i < $validatedData['numberOfServices']; $i++) {
                 $servicesData[] = [
                     'ProviderId' => $provider->id,
                     'ServiceName' => $validatedData['serviceNames'][$i],
                     'Description' => $validatedData['serviceDescriptions'][$i],
                     'Price' => $validatedData['servicePrices'][$i],
                 ];
             }
 
 
             // Bulk insert all services into the database
             Services::insert($servicesData);
 
             // Commit the transaction
             DB::commit();
 
             // Return a success response
             return response()->json(['message' => 'Service provider and services saved successfully', 'provider' => $provider, 'services' => $servicesData], 201);
         } catch (\Exception $e) {
             // Rollback the transaction if an error occurs
             DB::rollBack();
 
             // Return an error response
             return response()->json(['message' => 'Failed to save cemetery data. ' . $e->getMessage()], 500);
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
        $validatedData = [
            'name' => $this->name,
            'motto' => $this->motto,
            'email' => $this->email,
            'cellphoneNumber' => $this->cellphoneNumber,
            'numberOfServices' => $this->numberOfServices,
            'serviceNames' => $this->serviceNames,
            'serviceDescriptions' => $this->serviceDescriptions,
            'servicePrices' => $this->servicePrices,
        ];

        
        try {
        
            // Delete all associated services for the deleted ServiceProvider
            Services::where('ProviderId', $this->providerId)->delete();
            // Find the ServiceProvider by ID
            $provider = ServiceProviders::findOrFail($this->providerId);

            // Update the ServiceProvider data
            $provider->update([
                'Name' => $validatedData['name'],
                'Motto' => $validatedData['motto'],
                'Email' => $validatedData['email'],
                'ContactNumber' => $validatedData['cellphoneNumber'],
                // Add other model attributes here
            ]);
            // Prepare data for bulk insertion of services
            $servicesData = [];
            for ($i = 0; $i < $validatedData['numberOfServices']; $i++) {
                $servicesData[] = [
                    'ProviderId' => $provider->id,
                    'ServiceName' => $validatedData['serviceNames'][$i],
                    'Description' => $validatedData['serviceDescriptions'][$i],
                    'Price' => $validatedData['servicePrices'][$i],
                ];
            }

            // Bulk insert all services into the database
            Services::insert($servicesData);

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json(['message' => 'Service provider and services updated successfully', 'provider' => $provider, 'services' => $servicesData], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to update service provider and services. ' . $e->getMessage()], 500);
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
