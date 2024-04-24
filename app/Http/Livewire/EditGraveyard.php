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
    protected $listeners = ['viewSections'];

    public function viewSections($cemeteryId)
    {
        $sections = Sections::where('CemeteryID', $cemeteryId)->get();
        $this->sections = $sections;
        $this->viewSections($cemeteryId);
        // Set the section price if it's not null
        $this->sectionPrices = $sections->first()->ServicePrice;
        // Then show the modal
        $this->emit('showModal');
    }
    public function addPrice()
    {
        foreach ($this->sectionPrices as $sectionId => $price) {
            if ($price !== null) {
                // Find the section by SectionID
                $section = Sections::find($sectionId);

                // If the section exists, update the price
                if ($section) {
                    $section->update(['Price' => $price]);
                }
            }else{
                //display available price
            }
        }

        // Emit an event to notify that the records have been updated
        $this->emit('priceUpdated');

        // Close the modal
        $this->showModal = false;
    }
}
