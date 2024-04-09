<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Models\ServiceProviders;
use App\Models\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceProviderApi extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'motto' => 'required|string',
            'email' => 'required|string',
            'cellphoneNumber' => 'required|integer',
            'numberOfServices' => 'required|integer',
            'serviceNames.*' => 'required|string',
            'serviceDescriptions.*' => 'required|string',
            'servicePrices.*' => 'required|integer',
        ]);

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
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'motto' => 'required|string',
            'email' => 'required|string',
            'cellphoneNumber' => 'required|integer',
            'numberOfServices' => 'required|integer',
            'serviceNames.*' => 'required|string',
            'serviceDescriptions.*' => 'required|string',
            'servicePrices.*' => 'required|integer',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the ServiceProvider by ID and delete it
            ServiceProviders::destroy($id);

            // Delete all associated services for the deleted ServiceProvider
            Services::where('ProviderId', $id)->delete();
            // Find the ServiceProvider by ID
            $provider = ServiceProviders::findOrFail($id);

            // Update the ServiceProvider data
            $provider->update([
                'Name' => $validatedData['name'],
                'Motto' => $validatedData['motto'],
                'Email' => $validatedData['email'],
                'ContactNumber' => $validatedData['cellphoneNumber'],
                // Add other model attributes here
            ]);

            // Delete existing services associated with the ServiceProvider
            $provider->services()->delete();

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
    public function delete($id)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Find the ServiceProvider by ID
            $provider = ServiceProviders::findOrFail($id);

            // Delete all associated services for the ServiceProvider
            Services::where('ProviderId', $id)->delete();

            // Delete the ServiceProvider
            $provider->delete();

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json(['message' => 'Service provider and associated services deleted successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            return response()->json(['message' => 'Failed to delete service provider and associated services. ' . $e->getMessage()], 500);
        }
    }
}
