<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Sections;
use App\Models\Towns;
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


        //here we will get all the towns that are related to the region selected
        if ($this->region_selected != '') {
            $towns = Towns::where('region_id', $this->region_selected)->get();
        }




        return view('livewire.grave-admin', [
            'towns' => $towns,
            'regions' => $regions,

        ]);
    }
    public function addGrave()
    {

        //cemetery id which will link to the sections
        $cem_id = count($this->cemeteries) + 1;
        $t_graves = 0;
        //calculating then total graves to put into the cemetery table

        foreach ($this->sections as $sec) {
            $t_graves = $t_graves +  $sec['TotalGraves'];
        }


        if ($this->cemeteries_selected != 'other') {
            $cem_name = $this->cemeteries_selected;
        }


        // creates new cemetery if other is selected or updates the current sections in the database

        if ($this->cemeteries_selected == 'other') {



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
        }






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
                'CemeteryID' => $sec['CemeteryID'],
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
