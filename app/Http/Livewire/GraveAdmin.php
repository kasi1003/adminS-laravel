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

    public $editCemeteryName = false;

    //this function is only called once when the page loads
    public function mount()
    {
        $this->load_data();
    }
    //here we will load the data from the db needed for the form to be populated
    public function load_data()
    {
    }
    public function render()
    {


        $regions = Regions::all();
        $towns = Towns::all();
        $this->cemeteries = Cemeteries::all();
        //dd($this->cemeteries);


        //here we will get all the towns that are related to the region selected
        if ($this->region_selected != '') {
            $towns = Towns::where('region_id', $this->region_selected)->get();
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

            // Convert the array to a collection
            $sectionsCollection = collect($this->sections);

            // Get the IDs of sections to be updated
            $sectionIds = $sectionsCollection->pluck('id');

            // Update existing sections with the same CemeteryID
            Sections::where('CemeteryID', $cem_id)
                ->whereIn('id', $sectionIds)
                ->update([
                    'TotalGraves' => $sec['TotalGraves'],
                    'AvailableGraves' => $sec['TotalGraves'],
                    'SectionCode' => DB::raw('CONCAT("Section ", id)'),
                    // Update SectionCode based on the 'id'
                ]);

            // Delete sections with the same CemeteryID that weren't updated
            Sections::where('CemeteryID', $cem_id)
                ->whereNotIn('id', $sectionIds)
                ->delete();


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


        // creates new cemetery if other is selected or updates the current sections in the database

        /*if ($this->cemeteries_selected == 'other') {
            $cem_name = $this->grave_name;


            $cem_data = [
                'Region' => $this->region_selected,
                'CemeteryName' => $cem_name,
                'Town' => $this->town_selected,
                'NumberOfSections' => count($this->sections),
                'TotalGraves' =>  $t_graves,
                'AvailableGraves' =>  $t_graves,
                'CemeteryID' => count($this->cemeteries) + 1,
            ];

            Cemeteries::create(

                $cem_data
            );
        } else {
            $cem_data = [
                'Region' => $this->region_selected,

                'Town' => $this->town_selected,
                'NumberOfSections' => count($this->sections),
                'TotalGraves' =>  $t_graves,
                'AvailableGraves' =>  $t_graves,
                'CemeteryID' => count($this->cemeteries) + 1,
            ];

            Cemeteries::updateOrInsert(
                ['CemeteryID' => $this->cemeteries_selected],
                $cem_data
            );
        }*/






        /*[

            'CemeteryID' => $this->cemeteries_selected,
            'SectionCode' => $section_id,
            'TotalGraves' => $this->number_of_graves,
            'AvailableGraves' => $this->number_of_graves,
        ] */
        //adding the sections to the database

        foreach ($this->sections as $sec) {

            Sections::create([
                'SectionID' => $sec['SectionCode'],
                'CemeteryID' => $cem_id,
                'SectionCode' => 'Section ' . $sec['SectionCode'],
                'TotalGraves' => $sec['TotalGraves'],
                'AvailableGraves' => $sec['AvailableGraves'],
            ]);
        }

        $this->dispatchBrowserEvent('swal', [
            'title' => 'Grave Yard Added',
            'icon' => 'success',
            'iconColor' => 'green',
        ]);
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
