<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Sections;
use Livewire\Component;

class EditGraveyard extends Component
{
    public $showEditModal = false;
    public $selectedCemetery;

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

    public function render()
    {
        $cemeteries = Cemeteries::all();
        $sections = Sections::all(); // Retrieve data from the Sections model

        return view('livewire.edit-graveyard', compact('cemeteries', 'sections'));
    }
        
}
