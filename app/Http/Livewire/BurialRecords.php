<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


use App\Models\Rows;
use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use Livewire\Component;

class BurialRecords extends Component
{

    public $rows = [];
    public $rowOptions = [];
    public $section_code_selected;
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
        $this->cemeteries_selected = null;
        $this->section_select = null;
    }


    public function updatedCemeteriesSelected()
    {
        $this->section_select = null; // Clear the previous selection when a new cemetery is chosen
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
    public function getRowOptions()
    {
        $rows = [];
        if ($this->section_select) {
            // Retrieve rows associated with the selected section
            $sectionCode = $this->section_select;

            $rows = Rows::where('SectionCode','=', $sectionCode)->get('RowID');
            dd($rows->toArray());

        }

        return $rows;
    }


    /* 
    public function updatedSectionSelected()
    {
        // Check if a section is selected
        if ($this->section_select) {
            // Call API to fetch rows based on SectionCode
            $response = $this->fetchRowsFromAPI($this->section_select);

            // If response is successful and contains rowIDs, update rowOptions
            if ($response && isset($response['rowIDs'])) {
                $this->rowOptions = $response['rowIDs'];
            }
        } else {
            // Clear rowOptions if no section is selected
            $this->rowOptions = [];
        }
    }

    public function fetchRowsFromAPI($sectionCode)
    {
        // Construct API endpoint URL using sectionCode
        $url = url("http://localhost:8000/api/getRows/{$sectionCode}");

        // Fetch data from API using HTTP client
        $response = Http::get($url);
        Log::info('API Response:', ['url' => $url, 'response' => $response->json()]);
        // Check if API request is successful
        if ($response->successful()) {
            // Return JSON response
            return $response->json();
        } else {
            // Handle error if API request fails
            Log::error("RowID not found for section code: $sectionCode");
            return null;
        }
    } */
    public function render()
    {
        return view('livewire.burial-records', [
            'sectionOptions' => $this->getSectionOptions(),
            'rowOptions' => $this->getRowOptions()



        ]);
    }



    public function addRecord()
    {
    }
}
