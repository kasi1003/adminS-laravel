<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Sections;
use Livewire\Component;

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
    public function deleteCemetery($cemeteryId)
    {
        // Find the cemetery by ID
        $cemetery = Cemeteries::find($cemeteryId);

        if ($cemetery) {
            // Get the CemeteryID
            $cemeteryId = $cemetery->CemeteryID;

            // Delete the cemetery
            $cemetery->delete();

            // Delete related sections in the grave_sections table
            Sections::where('CemeteryID', $cemeteryId)->delete();
        }
    }
}
