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
        $availableGraves = [];

        if ($this->cemeteries_selected != 'other') {
            // Find the selected cemetery
            $cemetery = Cemeteries::where('CemeteryName', $this->cemeteries_selected)->first();

            if ($cemetery) {
                // Retrieve the AvailableGraves for the selected cemetery
                $availableGraves = range(1, $cemetery->AvailableGraves);
            }
        }

        return $availableGraves;
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
        // Validate the selected_grave and section_select
        if (
            $this->selected_grave && $this->section_select && $this->name && $this->surname && $this->date_of_birth
            && $this->date_of_death && $this->deathNumber
        ) {
            // Find the selected cemetery
            $cemetery = Cemeteries::where('CemeteryName', $this->cemeteries_selected)->first();

            if ($cemetery) {
                // Decrease the AvailableGraves by 1
                $cemetery->decrement('AvailableGraves');

                // Create the DeathNumber by combining CemeteryName, SectionCode, and selected_grave
                $deathNumber = $this->cemeteries_selected . $this->section_select . $this->selected_grave;

                // Create a data array for the new record
                $data = [
                    'CemeteryID' => $cemetery->CemeteryID,
                    'SectionCode' => $this->section_select,
                    'GraveNumber' => $this->selected_grave,
                    'Name' => $this->name,
                    'Surname' => $this->surname,
                    'DateOfBirth' => $this->date_of_birth,
                    'DateOfDeath' => $this->date_of_death,
                    'DeathNumber' => $deathNumber,
                ];

                // Create a new BurialRecordsMod record
                BurialRecordsMod::create($data);

                // Reset the form input values
                $this->selected_grave = null;
                $this->name = null;
                $this->surname = null;
                $this->date_of_birth = null;
                $this->date_of_death = null;

                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Record Added',
                    'icon' => 'success',
                    'iconColor' => 'green',
                ]);
            }
        }
    }
}

