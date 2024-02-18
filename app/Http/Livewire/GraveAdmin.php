<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use DB;
use Livewire\Component;

class GraveAdmin extends Component
{

    //variables
    public $region_selected;
    public $town_selected;
    public $grave_name;
    public $grave_number;
    public $cemeteries_selected;
    public $number_of_graves;
    public $sections = [];
    public $addSections = true;
    public $cemeteries;

    public $editMode = false;
    public $selectedCemetery;

    public $editCemeteryName = false;

    //this function is only called once when the page loads
    public function mount()
    {
        // Fetch the selected cemetery data based on the stored session data
        $selectedCemeteryDetails = session('selectedCemeteryDetails');

        if ($selectedCemeteryDetails) {
            $this->region_selected = $selectedCemeteryDetails->Region;
            $this->town_selected = $selectedCemeteryDetails->Town;
            $this->cemeteries_selected = $selectedCemeteryDetails->CemeteryID;
            $this->grave_name = $selectedCemeteryDetails->CemeteryName;

            // Populate other properties similarly
            // Set $editCemeteryName based on the condition
            $this->editCemeteryName = $this->cemeteries_selected == 'other' || empty($this->selectedRowCemeteryName);

            // Set $editMode to true when editing a row
            $this->editMode = true;
        }

        // Clear the session data
        session()->forget('selectedCemeteryDetails');
    }
    //here we will load the data from the db needed for the form to be populated
    public function load_data()
    {
    }
    public function render()
    {

        $this->cemeteries = Cemeteries::all();
        $regions = Regions::all();
        $towns = [];

        //dd($this->cemeteries);


        //here we will get all the towns that are related to the region selected
        if ($this->region_selected != '') {

            $towns = Towns::where('region_id', $this->region_selected)->get();

            // Debugging statement to check if towns are assigned to the variable
            dd("After fetching towns", $towns);
        }

        return view('livewire.grave-admin', [
            'towns' => $towns,
            'regions' => $regions,
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
    public function rules()
    {
        return [
            'region_selected' => 'required',
            'town_selected' => 'required',
            'cemeteries_selected' => 'required',
            'grave_name' => 'required_if:cemeteries_selected,other',
            // Add more rules for other properties if needed
        ];
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
                'Region' => $this->region_selected,
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
            // Create a new cemetery
            $cem_name = $this->grave_name;
            $cem_id = count($this->cemeteries) + 1;

            $cem_data = [
                'Region' => $this->region_selected,
                'CemeteryName' => $cem_name,
                'Town' => $this->town_selected,
                'NumberOfSections' => count($this->sections),
                'TotalGraves' => $t_graves,
                'AvailableGraves' => $t_graves,
                'CemeteryID' => $cem_id,
            ];

            Cemeteries::create($cem_data);
        }



        //adding the sections to the database

        foreach ($this->sections as $index => $sec) {
            // Calculate the section ID starting from 1
            $sectionID = $index + 1;

            Sections::updateOrCreate(
                ['CemeteryID' => $cem_id, 'SectionID' => $sectionID],
                [
                    'SectionCode' => 'Section ' . $sectionID,
                    'TotalGraves' => $sec['TotalGraves'],
                    'AvailableGraves' => $sec['AvailableGraves'],
                ]
            );
        }
        // Clear Livewire component properties
        $this->region_selected = null;
        $this->town_selected = null;
        $this->cemeteries_selected = null;
        $this->editCemeteryName = false;
        $this->grave_name = null;
        $this->grave_number = null;
        $this->number_of_graves = null;
        $this->sections = [];

        // Dispatch a SweetAlert message for successful submission
        $this->dispatchBrowserEvent('swal', [
            'title' => 'Grave Yard Added',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);

        // Redirect to the same page after form submission
        return redirect()->to('/graveyard-admin');
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



        $section_id = count($this->sections) + 1;

        array_push($this->sections, [

            'CemeteryID' => $this->cemeteries_selected,
            'SectionCode' => $section_id,
            'TotalGraves' => $this->number_of_graves,
            'AvailableGraves' => $this->number_of_graves,
        ]);

        $this->number_of_graves = "";



        $this->dispatchBrowserEvent('swal', [
            'title' => 'Section Added',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
        // session()->flash('message', 'Section Added');
    }
}
