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
    public $editCemeteryName = false;
    public $number_of_rows = [];
    public $search = '';

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
        //cemetery id which will link to the sections
        $cem_id = count($this->cemeteries) + 1;
        $t_graves = 0;
        //calculating then total graves to put into the cemetery table

        foreach ($this->sections as $sec) {
            $t_graves = $t_graves + $sec['TotalGraves'];
        }


        if ($this->cemeteries_selected != 'other') {
            // Existing cemetery selected, update the data in both tables
            $cem_id = $this->cemeteries_selected;
            $cem_name = $this->grave_name;

            // Check if the Graveyard Name input is empty
            if (empty($cem_name)) {
                $defaultCemetery = $this->cemeteries->where('CemeteryID', $cem_id)->first();
                $cem_name = $defaultCemetery->CemeteryName ?? '';
            }


            $cem_data = [
                'CemeteryName' => $cem_name,
                'Town' => $this->town_selected,
                'NumberOfSections' => count($this->sections),
                'TotalGraves' => $t_graves,
                'AvailableGraves' => $t_graves,
                'CemeteryID' => $cem_id,
            ];

            // Update the cemetery data
            Cemeteries::where('CemeteryID', $cem_id)->update($cem_data);

            // Delete existing sections with the same CemeteryID
            Sections::where('CemeteryID', $cem_id)->delete();

            // Create new sections based on the new inputs
            foreach ($this->sections as $index => $sec) {
                // Calculate the section ID starting from 1
                $sectionID = $index + 1;

                Sections::create([
                    'SectionID' => $sectionID,
                    'CemeteryID' => $cem_id,
                    'SectionCode' => 'Section ' . $sectionID,
                    'TotalGraves' => $sec['TotalGraves'],
                    'AvailableGraves' => $sec['AvailableGraves'],
                ]);
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
            $response = Http::post('http://localhost:8000/api/cemeteryPost', $validatedData );
            // Check if the API request was successful
            if ($response->successful()) {

                // Reset form data after successful submission
                $this->resetForm();

                // Optionally, display a success message to the user
                session()->flash('success', 'Graveyard and graves added successfully');
            } else {
                // Optionally, handle errors and display a message to the user
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
    public function updated($propertyName)
    {
        // Clear any previous validation errors when the user starts typing
        $this->resetErrorBag($propertyName);
    }
    public function modGrave($id, $type_of_mod)
    {
        //to delete the grave
        if ($type_of_mod == 'delete') {
            # code...
        }
        //to edit the grave
        if ($type_of_mod == 'edit') {
            # code...
        }
        dd($this->sections);
    }

    public function addSection()
    {
        // Add a new section to the $sections array
        $section_id = count($this->sections) + 1;

        array_push($this->sections, [

            'CemeteryID' => $this->cemeteries_selected,
            'SectionCode' => 'Section ' . $section_id, // You may need to adjust this based on your API requirements
            'TotalGraves' => $this->number_of_graves,
            'AvailableGraves' => $this->number_of_graves,
        ]);

        // Clear the input field after adding the section
        $this->number_of_graves = null;

        // Dispatch a success message
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Section Added',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
        // session()->flash('message', 'Section Added');
    }
}
