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

    //this function is only called once when the page loads
    
    public function mount()
    {
        $this->load_data();
        
    }
    public function load_data()
    {
        $this->regions = Regions::all();
        $this->cemeteries = Cemeteries::all(); // Load cemeteries data


        
    }

    // Call load_data() method when the component mounts
    public function render()
    {

        return view('livewire.grave-admin', [
            'regions' => $this->regions,
            'cemeteries' => $this->cemeteries
        ]);  
      }
    // Livewire Component
public function updatedRegionSelected($value)
{
    // Make an API request to fetch towns based on the selected region
    $response = Http::get("http://localhost:8000/api/towns/{$value}");

    // Update the towns dropdown options with the response data
    $this->towns = $response->json();
    dd($this->towns);
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
            // Prepare data to send to the API
            $data = [
                'grave_name' => $this->grave_name,
                'town_selected' => $this->town_selected,
                'grave_number' => $this->grave_number,
                'total_graves' => $this->number_of_graves,
                'sections' => $this->sections,
            ];

            try {
                // Make a POST request to the API endpoint
                $response = Http::post('http://localhost:8000/api/cemeteryPost', $data);

                if ($response->successful()) {
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
                } else {
                    // Handle unsuccessful API response
                    // You may want to log errors or display an error message to the user
                    // For now, we'll just return back to the same page
                    return back()->withErrors(['message' => 'Failed to submit form. Please try again.']);
                }
            } catch (\Exception $e) {
                // Handle exceptions
                // Log errors or display an error message to the user
                // For now, we'll just return back to the same page
                return back()->withErrors(['message' => 'An unexpected error occurred. Please try again.']);
            }
        }
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
