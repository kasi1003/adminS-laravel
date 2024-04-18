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

        try {
            // Validate the incoming request data
            $validatedData = $this->validate([
                'BuriedPersonsName' => 'required|string',
                'DateOfBirth' => 'required|date',
                'DateOfDeath' => 'required|date',
                'DeathCode' => 'required|integer',
            ]);

            // Start a transaction
            DB::beginTransaction();

            // Assuming you have $cemeteryID, $sectionCode, $rowID, and $graveNum defined somewhere

            $dataToUpdate = [
                'BuriedPersonsName' => $this->BuriedPersonsName,
                'DateOfBirth' => $this->DateOfBirth,
                'DateOfDeath' => $this->DateOfDeath,
                'DeathCode' => $this->DeathCode,
                'GraveStatus' => 1,
            ];

            $affectedRows = Graves::where('CemeteryID', $this->cemeteryID)
                ->where('SectionCode', $this->selectedSection)
                ->where('RowID', $this->selectedRow)
                ->where('GraveNum', $this->selectedGraveNumber)
                ->update($dataToUpdate);

            // Fetch the updated Grave record
            $updatedGrave = Graves::where('CemeteryID', $this->cemeteryID)
                ->where('SectionCode', $this->selectedSection)
                ->where('RowID', $this->selectedRow)
                ->where('GraveNum', $this->selectedGraveNumber)
                ->firstOrFail();

            // Commit the transaction
            DB::commit();

            // Optionally, you can include cemetery, section, row along with the updated grave in the response
            $this->reset(); // Clear input fields after successful submission
            $this->emit('recordAdded'); // Emit event to notify parent or other components
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Cemetery data updated successfully']);
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Return an error response
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Failed to update cemetery data. ' . $e->getMessage()]);
        }
    }
    }

