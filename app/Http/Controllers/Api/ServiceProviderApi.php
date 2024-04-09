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
}
