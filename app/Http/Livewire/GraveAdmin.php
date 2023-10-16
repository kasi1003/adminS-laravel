<?php

namespace App\Http\Livewire;

use App\Models\Cemeteries;
use App\Models\Regions;
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
    public $addSections=true;


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
        $cemeteries = Cemeteries::all();
        //here we will get all the towns that are related to the region selected
        if ($this->region_selected != '') {
            $towns = Towns::where('region_id', $this->region_selected)->get();
        }

        if ($this->town_selected != '') {
            $towns = Cemeteries::where('Town', $this->town_selected)->get();
        }


        return view('livewire.grave-admin', [
            'towns' => $towns,
            'regions' => $regions,
            'cemeteries' => $cemeteries
        ]);
    }
    public function addGrave()
    {
        $grave_data = [
            ''
        ];
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


    }
}
