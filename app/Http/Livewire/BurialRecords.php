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
    public $graveStatus;
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
    // Validation rules
    protected $rules = [
        'selectedCemetery' => 'required|integer',
        'selectedSection' => 'required|string',
        'selectedRow' => 'required|string', // Assuming it's a string based on migration
        'selectedGraveNumber' => 'required|integer',
        'name' => 'required|string',
        'surname' => 'required|string',
        'date_of_birth' => 'required|date',
        'date_of_death' => 'required|date',
        'death_number' => 'required|integer', // Assuming it's an integer based on migration
    ];

    public function addRecord()
    {
        // Validate the form inputs
        $this->validate();


        // Find the grave record based on the selected values
        // Find the grave record based on the selected values
        $grave = Graves::where('CemeteryID', $this->selectedCemetery)
            ->where('SectionCode', $this->selectedSection)
            ->where('RowID', $this->selectedRow)
            ->where('GraveNum', $this->selectedGraveNumber)
            ->first();
/*             dd($this->selectedCemetery, $this->selectedSection, $this->selectedRow, $this->selectedGraveNumber);
 */
        // Prepare the data to update
        $data = [
            'BuriedPersonsName' => $this->name . ' ' . $this->surname,
            'DateOfBirth' => $this->date_of_birth,
            'DateOfDeath' => $this->date_of_death,
            'DeathCode' => $this->death_number,
            'GraveStatus' => 1,
        ];

        // Update the grave record
        $grave->update($data);

        $this->resetForm();
    }
    // Helper method to reset form inputs after submission
    private function resetForm()
    {
        $this->selectedCemetery = null;
        $this->selectedSection = null;
        $this->selectedRow = null;
        $this->selectedGraveNumber = null;
        $this->graveStatus = null;
        $this->name = null;
        $this->surname = null;
        $this->date_of_birth = null;
        $this->date_of_death = null;
        $this->death_number = null;
    }
}