<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
use App\Models\Rows;
use Illuminate\Support\Facades\DB;
use App\Models\Graves;
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

         // Delete existing records associated with the given CemeteryID
         Sections::where('CemeteryID', $this->cemeteries_selected)->delete();
         Rows::where('CemeteryID', $this->cemeteries_selected)->delete();
         Graves::where('CemeteryID', $this->cemeteries_selected)->delete();
 
         // Start a database transaction
         DB::beginTransaction();
 
         try {
             // Update the Cemeteries record
             $cemetery = Cemeteries::findOrFail($this->cemeteries_selected);
             $cemetery->update([
                 'CemeteryName' => $validatedData['graveyardName'],
                 'Town' => $validatedData['townLocation'],
                 'NumberOfSections' => $validatedData['graveyardNumber'],
                 // Update other model attributes here
             ]);
 
             // Update or create sections, rows, and graves based on the updated data
             for ($i = 0; $i < $validatedData['graveyardNumber']; $i++) {
                 $sectionCode = 'S_' . $this->cemeteries_selected . '_' . ($i + 1);
 
                 // Update or create section
                 $section = Sections::updateOrCreate(
                     ['CemeteryID' => $this->cemeteries_selected, 'SectionCode' => $sectionCode],
                     ['Rows' => $validatedData['numberOfRows'][$i]]
                     // Add other model attributes here
                 );
 
                 // Update or create rows for this section
                 for ($j = 0; $j < $validatedData['numberOfRows'][$i]; $j++) {
                     $rowID = 'R_' . $this->cemeteries_selected . '_' . ($i + 1) . '_' . ($j + 1);
                     $row = Rows::updateOrCreate(
                         ['CemeteryID' => $this->cemeteries_selected, 'SectionCode' => $sectionCode, 'RowID' => $rowID],
                         ['AvailableGraves' => $validatedData['numberOfGraves'][$i][$j], 'TotalGraves' => $validatedData['numberOfGraves'][$i][$j]]
                         // Add other model attributes here
                     );
 
                     // Update or create graves for this row
                     $numberOfGraves = $validatedData['numberOfGraves'][$i][$j];
                     for ($k = 0; $k < $numberOfGraves; $k++) {
                         $graveNum = $k + 1;
                         $grave = Graves::updateOrCreate(
                             ['CemeteryID' => $this->cemeteries_selected, 'SectionCode' => $sectionCode, 'RowID' => $rowID, 'GraveNum' => $graveNum],
                             // Add other model attributes here if needed
                         );
                     }
                 }
             }
 
             // Commit the transaction
             DB::commit();
 
             // Return a success response
             return response()->json(['message' => 'Cemetery data updated successfully', 'cemetery' => $cemetery, 'section' => $section, 'row' => $row, 'grave' => $grave], 200);
         } catch (\Exception $e) {
             // Rollback the transaction if an error occurs
             DB::rollBack();
 
             // Return an error response
             return response()->json(['message' => 'Failed to update cemetery data. ' . $e->getMessage()], 500);
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
         // Create a new instance of the Cemeteries model and fill it with validated data
         $cemetery = Cemeteries::create([
            'CemeteryName' => $validatedData['graveyardName'],
            'Town' => $validatedData['townLocation'],
            'NumberOfSections' => $validatedData['graveyardNumber'],
            // Add other model attributes here
        ]);
        // Create sections based on the number of sections
        // Get the CemeteryID after creating the cemetery
        $cemeteryID = $cemetery->getKey();
        // Prepare an array to store the data for all sections
        $sectionsData = [];
        // Loop through each section and prepare data for insertion
        for ($i = 0; $i < $validatedData['graveyardNumber']; $i++) {
            $sectionCode = 'S_' . $cemeteryID . '_' . ($i + 1); // Increment $i by 1 to start from 1

            // Add section data to the array
            $sectionsData[] = [
                'CemeteryID' => $cemeteryID,
                'SectionCode' => $sectionCode,
                'Rows' => $validatedData['numberOfRows'][$i], // Store numberOfRows for each section
                // Add other model attributes here
            ];

            // Add rows data for each section
            $rowsData = [];
            for ($j = 0; $j < $validatedData['numberOfRows'][$i]; $j++) {
                $rowID = 'R_' . $cemeteryID . '_' . ($i + 1) . '_' . ($j + 1); // Increment $j by 1 to start from 1

                // Add row data to the array
                $rowsData[] = [
                    'CemeteryID' => $cemeteryID,
                    'SectionCode' => $sectionCode,
                    'RowID' => $rowID,
                    'AvailableGraves' => $validatedData['numberOfGraves'][$i][$j], // Store numberOfGraves for each row
                    'TotalGraves' => $validatedData['numberOfGraves'][$i][$j], // Store numberOfGraves for each row

                    // Add other model attributes here
                ];
                // Create graves based on the available graves in the row
                for ($k = 0; $k < $validatedData['numberOfGraves'][$i][$j]; $k++) {
                    $graveNum = $k + 1; // Increment $k by 1 to start from 1

                    // Create a new grave and fill it with data
                    $grave = [
                        'CemeteryID' => $cemeteryID,
                        'SectionCode' => $sectionCode,
                        'RowID' => $rowID,
                        'GraveNum' => $graveNum,
                        // Add other model attributes here
                    ];

                    // Insert the grave into the database
                    Graves::create($grave);
                }
            }
            Rows::insert($rowsData);
        }

        // Bulk insert all sections into the databas
        Sections::insert($sectionsData);
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
