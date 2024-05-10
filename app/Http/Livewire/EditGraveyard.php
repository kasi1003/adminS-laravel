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
    public $cemeteries = [];
    public $sections = [];
    public $rows = [];
    public $graves = [];
    public $cemeteryId;
    public $deleteCemId;
    public $showModal;
    public $sectionPrices = [];

    public function mount()
    {
        // Fetch cemetery data from your database

    }
    public function editPrice($sectionId)
    {
        $this->editingSectionId = $sectionId;
    }

    public function savePrice($sectionId)
    {
        $section = Sections::findOrFail($sectionId);
        $section->Price = $this->sectionPrices[$sectionId];
        $section->save();
        $this->editingSectionId = null;
    }

    public function cancelEdit()
    {
        $this->editingSectionId = null;
    }

    public function editCemetery($cemeteryId)
    {
        $this->emit('editCemetery', $cemeteryId);
        $this->emit('updateCemeterySelect', $cemeteryId); // Emit the event to update the selected cemetery in the form component

    }
    public function viewSections($cemeteryId)
    {

        // Fetch sections associated with the selected cemetery
        $this->sections = Sections::where('CemeteryID', $cemeteryId)->get();
        // Emit an event to show the modal
        $this->emit('showModal');
    }
    protected $listeners = ['deleteGrave' => 'deleteCemetery'];
    public function deleteConfirm($cemeteryId)
    {
        $this->deleteCemId = $cemeteryId;
        $this->dispatchBrowserEvent('confirmDelete');
    }
    public function deleteCemetery()
    {
        // Delete records associated with the selected cemetery ID
        $cemeteries = Cemeteries::where('CemeteryID', $this->deleteCemId)->first();
        $sections = Sections::where('CemeteryID', $this->deleteCemId)->delete();
        $rows = Rows::where('CemeteryID', $this->deleteCemId)->delete();
        $graves = Graves::where('CemeteryID', $this->deleteCemId)->delete();

        if ($cemeteries) {
            $cemeteries->delete(); // Delete the cemetery only if it exists
            $this->dispatchBrowserEvent('cemDeleted'); // Dispatch event after deletion
        } else {
            // Handle case where cemetery was not found
        }
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
    public function render()
    {
        $this->cemeteries = Cemeteries::all(); // Fetch cemeteries once
        $graves = Graves::all();
        // No need to fetch all sections here
        $rows = Rows::all();

        return view('livewire.edit-graveyard', ['graves' => $graves, 'cemeteries' => $this->cemeteries, 'sections' => $this->sections, 'rows' => $rows]);
    }
}
