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
