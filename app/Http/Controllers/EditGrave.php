<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sections;
use Illuminate\Http\Request;
use App\Models\Cemeteries;
use App\Models\Regions;
use App\Models\Towns;



class EditGrave extends Controller
{
    //variables

    public $region_selected;
    public $town_selected;
    public $grave_name;
    public $grave_number;
    public $number_of_graves;
    public $sections = [];
    public $addSections = true;
    public $cemeteries;
    public $cemetery;
    public $regions;
    public $cemeteries_selected = 'other'; // Initialize with 'other' to hide the cemetery name input
    public $editCemeteryName = false;

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
            'regions' => $regions,


        ]);






    }
    public function index()
    {
        $regions = Regions::all();
        $towns = Towns::all();


        //here we will get all the towns that are related to the region selected
        if ($this->region_selected != '') {
            $towns = Towns::where('region_id', $this->region_selected)->get();
        }







        $cemeteries = Cemeteries::all();
        $sections = Sections::all();
        return view('edit-cem', compact('cemeteries'));
    }
    public function updating($propertyName, $value)
    {
        if ($propertyName === 'cemeteries_selected') {
            $this->editCemeteryName = $value !== 'other';
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



        } else {
            // Clear the select inputs
            $this->region_selected = null;
            $this->town_selected = null;
            $this->sections = []; // Assuming $sections is an array
            $this->cemeteries_selected = null; // Add this line to clear CemeteryName
            $this->grave_number = null;

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


    public function update(Request $request, $id)
    {
        $request->validate([
            'CemeteryName' => 'required',
            'Region' => 'required',
            'NumberOfSections' => 'required',
            'TotalGraves' => 'required|numeric',
            'AvailableGraves' => 'required|numeric',

        ]);
        $cemeteries = Cemeteries::find($id);
        $cemeteries->update($request->all());
        return redirect()->route('/resources/views/edit-cem.blade.php')->with('success', 'Updated Successfully');
    }
    public function edit($id)
    {
        $cemeteries = Cemeteries::find($id);
        return view('/resources/views/edit-cem.blade.php', compact('post'));
    }
    public function destroy($id)
    {
        $cemeteries = Cemeteries::find($id);
        $cemeteries->delete();
        return redirect()->route('/resources/views/edit-cem.blade.php')->with('success', 'Post deleted successfully');
    }
}
