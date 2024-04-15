<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Rows;
use App\Models\Cemeteries;
use App\Models\Graves;
use App\Models\Sections;
use App\Models\Towns;
use Livewire\Component;

class BurialRecords extends Component
{
    public $selectedGraveNumber;
    public $cemeteries;
    public $sections = [];
    public $rows = [];
    public $graveNumbers = [];
    public $cemeteryID;
    public $selectedCemetery;
    public $selectedSection;
    public $selectedRow;
    public $selectedGraveNum;

    public $death_number;
    public $name;
    public $surname;
    public $date_of_birth;

    public $date_of_death;
    public $validatedData = [];


    public function mount()
    {
        $this->cemeteries = Cemeteries::all();
    }


    public function updatedSelectedCemetery($value)
    {
        $this->sections = Sections::where('CemeteryID', $value)->get();
        $this->cemeteryID = $value;
        $this->rows = []; // Reset rows when changing cemetery
        $this->selectedRow = null; // Reset selected row when changing cemetery
        $this->graveNumbers = []; // Reset grave numbers when changing cemetery
        $this->selectedGraveNum = null; // Reset selected grave number when changing cemetery
    }

    public function updatedSelectedSection($value)
    {
        $this->rows = Rows::where('SectionCode', $value)->get();

        $this->graveNumbers = []; // Reset grave numbers when changing section
        $this->selectedGraveNum = null; // Reset selected grave number when changing section
    }

    public function updatedSelectedRow($value)
    {
        $this->graveNumbers = Graves::where('RowID', $value)->pluck('GraveNum', 'id')->toArray();
        $this->selectedGraveNumber = null; // Reset selected grave number when changing row
        // Debugging: Output the selected cemetery name and its ID
    }
    public function updatedSelectedGraveNumber($value)
    {
        $this->selectedGraveNumber = $value;
    }


    public function render()
    {
        return view('livewire.burial-records');
    }

    public function addRecord()
    {


        // Prepare the data to be sent to the API
        $validatedData = [
            'BuriedPersonsName' => $this->name . ' ' . $this->surname, // Concatenate name and surname
            'DateOfBirth' => $this->date_of_birth,
            'DateOfDeath' => $this->date_of_death,
            'DeathCode' => $this->death_number,
        ];

        // Make a PUT request to the API endpoint with the cemetery ID
        $response = Http::put('http://localhost:8000/api/addBurialRecord/' . $this->cemeteryID . '/' . $this->selectedSection . '/' . $this->selectedRow . '/' . $this->selectedGraveNumber, $validatedData);

        // Check if the request was successful
        if ($response->successful()) {
            // Optionally, you can update the Livewire component state or show a success message
            //$this->resetForm(); // Reset the form fields
            // You might want to emit an event or reload data after a successful request
        } else {
            // Handle the case where the request failed
            // You can display an error message or perform any necessary actions
        }
    }
}
