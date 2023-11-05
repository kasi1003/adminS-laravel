<?php

namespace App\Http\Livewire;

use App\Models\BurialRecordsMod;
use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use Livewire\Component;

class BurialRecords extends Component
{
    public $selected_grave; // Add this property to store the selected grave number

    public $cemeteries;
    public $section_select;
    public $grave_number_select;
    public $name;
    public $surname;
    public $date_of_death;
    public $date_of_birth;
    public $death_number;
    public $section_code;

    public $buried_records;
    public $cemeteries_selected;
    public $section_selected; // Add this property to store the selected section

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



    public function getAvailableGraves()
    {
        $sectionCodes = [];

        if ($this->cemeteries_selected != 'other') {
            // Find the selected cemetery
            $cemetery = Cemeteries::where('CemeteryName', $this->cemeteries_selected)->first();

            if ($cemetery) {
                // Retrieve sections with the same CemeteryID
                $sections = Sections::where('CemeteryID', $cemetery->CemeteryID)->get();

                // Extract SectionCode values
                $sectionCodes = $sections->pluck('SectionCode');
            }
        }

        return $sectionCodes;
    }


    public function render()
    {
        $this->sections = Sections::all();


        $buried_records = BurialRecordsMod::all();

        return view('livewire.burial-records', [
            'buried_records' => $buried_records,
            'sectionOptions' => $this->getSectionOptions(),
            'availableGraves' => $this->getAvailableGraves(),
        ]);
    }
    public function addRecord()
    {
        // Validate the selected_grave here if needed
        if ($this->selected_grave) {
            // Find the section based on the CemeteryID
            $cemetery = Cemeteries::where('CemeteryName', $this->cemeteries_selected)->first();

            if ($cemetery) {
                $section = Sections::where('CemeteryID', $cemetery->CemeteryID)->first();

                if ($section) {
                    // Check if the selected grave is available
                    if ($section->AvailableGraves > 0) {
                        // Update the BurialRecordsMod model with the selected grave
                        $burialRecord = new BurialRecordsMod();
                        $burialRecord->GraveNumber = $this->selected_grave;
                        $burialRecord->save();

                        // Decrease the AvailableGraves by 1
                        $section->decrement('AvailableGraves');
                    }
                }
            }

            // Reset the selected_grave to null
            $this->selected_grave = null;
        }
    }
}

