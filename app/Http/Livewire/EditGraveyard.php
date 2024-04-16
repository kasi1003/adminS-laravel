<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Graves;

use App\Models\Sections;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class EditGraveyard extends Component
{
    public $showEditModal = false;
    public $selectedCemetery;
    public $cemeteries;
    public $sections;
    public $cemeteryId;


    public function mount()
    {
        // Fetch cemetery data from your database
        $this->cemeteries = Cemeteries::all();
        $this->sections = Sections::all();

        
    }
    public function render()
    {
        $graves = Graves::all();
        return view('livewire.edit-graveyard', ['graves' => $graves]);
    }
    


   
    public function editCemetery($cemeteryId)
    {
        $this->emit('editCemetery', $cemeteryId);
        $this->emit('updateCemeterySelect', $cemeteryId); // Emit the event to update the selected cemetery in the form component

    }
    
    public function deleteCemetery($cemeteryID)
{
    // Make a DELETE request to the API endpoint
    $response = Http::delete('http://localhost:8000/api/deleteCem/' . $cemeteryID);

    // Handle the response accordingly
    if ($response->successful()) {
        // Cemetery deleted successfully
        // Show success message to the user
        session()->flash('success', 'Cemetery deleted successfully.');
        // Update cemetery data after deletion
        $this->cemeteries = $this->cemeteries->reject(function ($cemetery) use ($cemeteryID) {
            return $cemetery->id === $cemeteryID;
        });
    } else {
        // Failed to delete cemetery
        // Show error message to the user
        session()->flash('error', 'Failed to delete cemetery.');
    }

    // Optionally, you can refresh the cemetery data after deletion
    $this->load_data(); // Assuming this method loads cemetery data
}

}
