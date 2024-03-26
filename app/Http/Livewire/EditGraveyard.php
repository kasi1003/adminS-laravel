<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Sections;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditGraveyard extends Component
{
    public $showEditModal = false;
    public $selectedCemetery;
    public $cemeteries;
    public $sections;
    public function mount()
    {
        // Fetch cemetery data from your database
        $this->cemeteries = Cemeteries::all();
        $this->sections = Sections::all();

        
    }
    public function render()
    {

        return view('livewire.edit-graveyard');
    }
    public function redirectToAdminPage($cemeteryId)
    {
        // Store the selected cemetery details in session
        $selectedCemeteryDetails = Cemeteries::find($cemeteryId);
        session(['selectedCemeteryDetails' => $selectedCemeteryDetails]);

        // Redirect to the admin page
        return redirect()->to('/graveyard-admin');
    }


    public function openEditModal($cemeteryId)
    {
        $this->selectedCemetery = Cemeteries::find($cemeteryId);
        $this->showEditModal = true;
    }

    public function saveChanges()
    {
        $this->validate([
            'selectedCemetery.CemeteryName' => 'required',
            'selectedCemetery.Town' => 'required',
            'selectedCemetery.NumberOfSections' => 'required|integer',
            'selectedCemetery.TotalGraves' => 'required|integer',
            'selectedCemetery.AvailableGraves' => 'required|integer',
        ]);

        $this->selectedCemetery->save();
        $this->showEditModal = false;
    }
    // Livewire component
    public function deleteCemetery($cemeteryID)
    {
        // Make a DELETE request to the API endpoint to delete records associated with the selected cemetery ID
        $response = Http::delete('http://localhost:8000/api/deleteCem/' . $cemeteryID);

        // Handle the response accordingly
        if ($response->successful()) {
            // Records deleted successfully
            // Optionally, you can show a success message to the user
        } else {
            // Failed to delete records
            // Optionally, you can show an error message to the user
        }
    }
}
