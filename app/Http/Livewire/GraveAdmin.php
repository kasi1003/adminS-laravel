<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use DB;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class GraveAdmin extends Component
{
    //variables
    public $region_selected;
    public $town_selected;
    public $grave_name;
    public $grave_number;
    public $cemeteries_selected;
    public $number_of_graves;
    public $addSections = true;
    public $cemeteries;
    public $editMode = false;
    public $selectedCemetery;
    public $sections = [];
    public $regions = [];
    public $towns = [];
    public $isLoading = true;
    public $editCemeteryName;
    public $number_of_rows = [];
    public $search = '';
    public $selectedCemeteryId;
    public $newGraveyardName;
    //this function is only called once when the page loads

    public function mount()
    {
        $this->load_data();
        $this->loadTowns();
    }
    public function loadTowns()
    {
        $this->isLoading = true;
        $this->towns = Towns::where('name', 'like', '%' . $this->search . '%')->get();
        $this->isLoading = false;
    }
    //here we will load the data from the db needed for the form to be populated
    public function load_data()
    {
        $this->number_of_rows = [];
        $this->regions = Regions::all();
        $this->cemeteries = Cemeteries::all();

        $this->towns = Towns::all();
    }
    public function render()
    {

        $this->loadTowns();
        return view('livewire.grave-admin', [
            'regions' => $this->regions,
        ]);
    }




    public function updating($propertyName, $value)
    {
        if ($propertyName === 'cemeteries_selected') {
            if ($value != 'other') {
                // Existing cemetery selected, allow editing of cemetery name
                $this->editCemeteryName = true;

                // Fetch default data for the selected cemetery and set Livewire properties
                $selectedCemetery = Cemeteries::find($value); // Replace with your actual model
                if ($selectedCemetery) {
                    $this->region_selected = $selectedCemetery->Region;
                    $this->town_selected = $selectedCemetery->Town;

                    // Populate the number_of_graves input only if it's null
                    if ($this->number_of_graves === null) {
                        $this->number_of_graves = $selectedCemetery->defaultNumberOfGraves;
                    }

                    // Other properties are updated similarly

                    $this->grave_name = $selectedCemetery->CemeteryName;
                }
            } else {
                // 'Other' selected, disable editing of cemetery name
                $this->editCemeteryName = false;
            }
        }
    }

    public function addGrave()
    {

        if ($this->cemeteries_selected != 'other') {
            // Fetch the primary key value of the selected cemetery
            $cemetery = Cemeteries::find($this->cemeteries_selected);
            if (!$cemetery) {
                // Handle the case where the selected cemetery is not found
                // Return an error message or redirect the user
                return;
            }
            $cemeteryID = $cemetery->CemeteryID;

            // Prepare data for updating the cemetery
            $validatedData = [
                'graveyardName' => $this->grave_name, // Use the selected cemetery name
                'townLocation' => $this->town_selected,
                'graveyardNumber' => $this->grave_number,
                'numberOfRows' => $this->number_of_rows,
                'numberOfGraves' => $this->number_of_graves,
            ];

            // Make a PUT request to the API endpoint with the cemetery ID
            $response = Http::put('http://localhost:8000/api/editCem/' . $cemeteryID, $validatedData);

            // Handle the response accordingly
            if ($response->successful()) {
                // Cemetery data updated successfully
                // Show success message to the user
            } else {
                // Failed to update cemetery data
                // Show error message to the user
            }
        } else {
            // Prepare data for adding graves to an existing cemetery
            $validatedData = [
                'graveyardName' => $this->grave_name, // Use the selected cemetery name
                'townLocation' => $this->town_selected,
                'graveyardNumber' => $this->grave_number,
                'numberOfRows' => $this->number_of_rows,
                'numberOfGraves' => $this->number_of_graves,
            ];
            // Make a POST request to the API endpoint
            $response = Http::post('http://localhost:8000/api/postCem', $validatedData);
            // Check if the API request was successful
            if ($response->successful()) {

                // Reset form data after successful submission
                // Show SweetAlert for successful submission
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Success!',
                    'text' => 'Cemetery data saved successfully',
                    'icon' => 'success',
                ]);
                $this->resetForm();

                // Optionally, display a success message to the user
                session()->flash('success', 'Graveyard and graves added successfully');
            } else {
                // Optionally, handle errors and display a message to the user
                // Show SweetAlert for failed submission
                $this->dispatchBrowserEvent('swal', [
                    'title' => 'Error!',
                    'text' => 'Failed to submit cemetery data',
                    'icon' => 'error',
                    'confirmButtonText' => 'OK'
                ]);
                session()->flash('error', 'Failed to add graveyard and graves');
            }
        }
    }
    private function resetForm()
    {
        $this->town_selected = null;
        $this->cemeteries_selected = null;
        $this->grave_name = null;
        $this->grave_number = null;
        $this->sections = [];
        $this->number_of_graves = [];
        $this->number_of_rows = [];
    }
    protected $listeners = ['editCemetery', 'updateCemeterySelect'];

    public function editCemetery($cemeteryId)
    {
        $this->cemeteries_selected = $cemeteryId;
        $this->editCemeteryName = $cemeteryId !== 'other';

        // Fetch the cemetery name corresponding to the selected cemetery ID
        if ($this->editCemeteryName) {
            $cemetery = Cemeteries::find($cemeteryId);
            if ($cemetery) {
                $this->newGraveyardName = $cemetery->CemeteryName; // Set the cemetery name as the value for the input field
            }
        } else {
            $this->newGraveyardName = null;
        }
    }
    public function updateCemeterySelect($cemeteryId)
    {
        $this->cemeteries_selected = $cemeteryId;
    }
}
