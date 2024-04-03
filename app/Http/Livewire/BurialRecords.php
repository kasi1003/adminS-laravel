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
    public function updatedSectionSelect($value)
    {
        // Extract CemeteryID and SectionCode from the selected value
        list($sectionCode, $cemeteryId) = explode('_', $value);
        // Fetch the CemeteryID using the Cemetery name
        $cemetery = Cemeteries::where('CemeteryName', $this->cemeteries_selected)->first();

        // Fetch RowID values based on CemeteryID and SectionCode
        $this->rowOptions = Graves::select('RowID')
            ->where('CemeteryID', $cemetery)
            ->where('SectionCode', $sectionCode)
            ->distinct()
            ->get();
    }


    public function render()
    {
        $this->sections = Sections::all();


        $rows = Graves::pluck('RowID')->unique()->toArray();


        return view('livewire.burial-records', [
            'buried_records' => Graves::all(),
            'sectionOptions' => $this->getSectionOptions(),

        ]);
    }



    public function addRecord()
    {
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

            // Create a new Grave record
            Graves::create($data);

            // Call the method to update available grave numbers
            $this->load_data();

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
