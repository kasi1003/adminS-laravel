<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Graves;
use App\Models\Rows;

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

        // Delete records associated with the selected cemetery ID from Sections, Rows, and Graves models
        // Delete records associated with the selected cemetery ID from Sections, Rows, and Graves models
        Cemeteries::where('CemeteryID', $cemeteryID)->delete();
        Sections::where('CemeteryID', $cemeteryID)->delete();
        Rows::where('CemeteryID', $cemeteryID)->delete();
        Graves::where('CemeteryID', $cemeteryID)->delete();
    }
}
