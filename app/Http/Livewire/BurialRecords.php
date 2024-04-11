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
    public $cemeteries;
    public $sections = [];
    public $rows = [];
    public $graveNumbers = [];

    public $selectedCemetery;
    public $selectedSection;
    public $selectedRow;
    public $selectedGraveNum;

    public function mount()
    {
        $this->cemeteries = Cemeteries::all();
    }

    public function updatedSelectedCemetery($value)
    {
        $this->sections = Sections::where('CemeteryID', $value)->get();
        $this->selectedSection = null; // Reset selected section when changing cemetery
        $this->rows = []; // Reset rows when changing cemetery
        $this->selectedRow = null; // Reset selected row when changing cemetery
        $this->graveNumbers = []; // Reset grave numbers when changing cemetery
        $this->selectedGraveNum = null; // Reset selected grave number when changing cemetery
    }

    public function updatedSelectedSection($value)
    {
        $this->rows = Rows::where('SectionCode', $value)->get();
        $this->selectedRow = null; // Reset selected row when changing section
        $this->graveNumbers = []; // Reset grave numbers when changing section
        $this->selectedGraveNum = null; // Reset selected grave number when changing section
    }

    public function updatedSelectedRow($value)
    {
        $this->graveNumbers = Graves::where('RowID', $value)->pluck('GraveNum', 'id')->toArray();
        $this->selectedGraveNumber = null; // Reset selected grave number when changing row
    }

    public function render()
    {
        return view('livewire.burial-records');
    }

    public function addRecord()
    {
        // Validate your input data
        $this->validate([
            'selectedCemetery' => 'required',
            'selectedSection' => 'required',
            'selectedRow' => 'required',
            'selectedGraveNum' => 'required', // Add validation for grave number if necessary
        ]);
    
        // Placeholder logic for adding the record
        // You can replace this with your actual logic to create a new record in the database
        // For demonstration purposes, I'm just logging the selected values
        Log::info('Cemetery: ' . $this->selectedCemetery);
        Log::info('Section: ' . $this->selectedSection);
        Log::info('Row: ' . $this->selectedRow);
        Log::info('Grave Number: ' . $this->selectedGraveNum);
    
        // Reset the form fields after adding the record
        $this->reset([
            'selectedSection',
            'selectedRow',
            'selectedGraveNum',
        ]);
    
        // Optionally, you can emit an event to trigger any updates in other components or notify the user
        $this->emit('recordAdded', 'Record added successfully!');
    }
    
}