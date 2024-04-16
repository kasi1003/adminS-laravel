<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use DB;
use Illuminate\Support\Facades\Log;

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



    //Populating selected cemetery form
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
                //dd($this->newGraveyardName);
            }
        } else {
            $this->newGraveyardName = null;
        }
        // If cemetery selected is 'other' and editCemeteryName is true, set grave_name to newGraveyardName
        if ($this->cemeteries_selected !== 'other' && $this->editCemeteryName) {
            $this->grave_name = $this->newGraveyardName;
        } else {
            $this->grave_name = null; // Reset grave_name if cemetery selected is not 'other' or editCemeteryName is false
        }
    }
    public function updateCemeterySelect($cemeteryId)
    {
        $this->cemeteries_selected = $cemeteryId;
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
    

    //Connection to api endpoint(Put)
    public function updateCemeteryData()
    {
        // Call the getCemeteryID function to get the CemeteryID
        // Prepare data for updating the cemetery
        $validatedData = [
            'graveyardName' => $this->grave_name, // Use the selected cemetery name
            'townLocation' => $this->town_selected,
            'graveyardNumber' => $this->grave_number,
            'numberOfRows' => $this->number_of_rows,
            'numberOfGraves' => $this->number_of_graves,
        ];

        // Make a PUT request to the API endpoint with the cemetery ID
        $response = Http::put('http://localhost:8000/api/editCem/' . $this->cemeteries_selected, $validatedData);

        // Handle the response accordingly
        if ($response->successful()) {
            // Cemetery data updated successfully
            // Show success message to the user
        } else {
            // Failed to update cemetery data
            // Show error message to the user
        }
    }

    //Connection to api endpoint(Post)
    public function addCemeteryData()
    {
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


            $this->resetForm();

            session()->flash('success', 'Graveyard and graves added successfully');
        } else {

            session()->flash('error', 'Failed to add graveyard and graves');
        }
    }

    public function addGrave()
    {

        if ($this->cemeteries_selected != 'other') {
            $this->updateCemeteryData();
        } else {
            $this->addCemeteryData();
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
}
