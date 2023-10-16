<?php

namespace App\Http\Livewire;

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
    public $number_of_graves;


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

        //here we will get all the towns that are related to the region selected
        if ($this->region_selected != '') {
            $towns = Towns::where('region_id', $this->region_selected)->get();
        }




        return view('livewire.grave-admin', [
            'towns' => $towns,
            'regions' => $regions
        ]);
    }
    public function addGrave()
    {
        $grave_data=[
            ''
        ];
    }
}
