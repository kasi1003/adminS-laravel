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
    public $editingSectionId;
    public $cemeteries;
    public $sections;
    public $cemeteryId;
    public $showModal;
    public $sectionPrices;

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
        Cemeteries::where('CemeteryID', $cemeteryID)->delete();
        Sections::where('CemeteryID', $cemeteryID)->delete();
        Rows::where('CemeteryID', $cemeteryID)->delete();
        Graves::where('CemeteryID', $cemeteryID)->delete();
    }

    public function viewSections($cemeteryId)
    {
        // Fetch sections associated with the selected cemetery
        $this->sections = Sections::where('CemeteryID', $cemeteryId)->get();
        // Emit an event to show the modal
        $this->emit('showModal');
    }
    public function editSection($sectionId)
    {
        $this->editingSectionId = $sectionId;
    }
    
    public function addPrice()
    {
        foreach ($this->sectionPrices as $sectionId => $price) {
            $section = Sections::findOrFail($sectionId);
            $section->Price = $price;
            $section->save();
        }
        // Optionally, you can emit an event to inform the parent component that the prices have been updated
        $this->emit('pricesUpdated');
        // Optionally, you can reset the form or any relevant properties after the update
        $this->reset(['sectionPrices', 'sectionIds']);
    }
}
