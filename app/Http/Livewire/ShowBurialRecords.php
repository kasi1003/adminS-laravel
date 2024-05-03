<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;
use App\Models\Graves;



class ShowBurialRecords extends Component
{
    public $graveIdToDelete;
    public $graveId;
    
    public function confirmDelete($graveId)
    {
        // Set the graveId property
        $this->graveIdToDelete = $graveId;

        // Dispatch a SweetAlert confirmation dialog
        $this->dispatchBrowserEvent('swal:confirmDelete', ['graveId' => $this->graveIdToDelete]);
    }

    // Inside your ShowBurialRecords component
    public function deleteGrave($graveId)
    {
        // Find the grave record by ID
        $grave = Graves::find($graveId);
        if ($grave) {
            // Nullify the specified columns
            $grave->update([
                'GraveStatus' => null,
                'BuriedPersonsName' => null,
                'DateOfBirth' => null,
                'DateOfDeath' => null,
                'DeathCode' => null,
            ]);
        }

        // Optionally, you can reload the graves data after deletion
        $this->render();
    }

    public function render()
    {
        // Fetch graves data from the Graves model
        $graves = Graves::all();

        // Pass the fetched data to the view
        return view('livewire.show-burial-records', compact('graves'));
    }
}
