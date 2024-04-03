<?php

namespace App\Http\Livewire;

use App\Models\Graves;
use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use Livewire\Component;

class BurialRecords extends Component
{

    public $rows = [];
    public $rowOptions = [];

    public $cemeteries_selected;
    public $section_selected;
    public $selected_grave;
    public $cemeteries;
    public $section_select;
    public $grave_number_select;
    public $name;
    public $surname;
    public $date_of_death;
    public $date_of_birth;
    public $death_number;
    public $section_code;
    public $sections;
    public $availableGraves = [];
    public $buried_records;
    // Add this property to store the selected section

    public function mount()
    {
        $this->load_data();
    }

    public function load_data()
    {
        $this->cemeteries = Cemeteries::all();
    }


    public function updatedCemeteriesSelected()
    {
        $this->section_selected = null; // Clear the previous selection when a new cemetery is chosen
    }

    public function getSectionOptions()
    {
        $sections = [];

        if ($this->cemeteries_selected != 'other') {
            // Find the selected cemetery
            $cemetery = Cemeteries::where('CemeteryName', $this->cemeteries_selected)->first();

            if ($cemetery) {
                // Retrieve sections with the same CemeteryID
                $sections = Sections::where('CemeteryID', $cemetery->CemeteryID)->get();
            }
        }

        return $sections;
    }

  

    public function render()
    {
        return view('livewire.burial-records', [
            'sectionOptions' => $this->getSectionOptions(),
        ]);
    }



    public function addRecord()
    {
        
    }
}
