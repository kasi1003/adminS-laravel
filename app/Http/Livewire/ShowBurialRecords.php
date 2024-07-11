<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceProviders;
use App\Models\Graves;



class ShowBurialRecords extends Component
{
    public $graveIdToDelete;
    public $graveId;
    public $graveID;

    protected $dates = ['archived_at'];

    protected $listeners = ['deleteRecord' => 'deleteGrave'];
    public function deleteConfirm($graveId)
    {
        $this->graveID = $graveId;
        $this->dispatchBrowserEvent('confirmDelete');
    }

    // Inside your ShowBurialRecords component
    public function deleteGrave()
    {
        // Find the grave record by ID
        $grave = Graves::find($this->graveID);
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
        $this->dispatchBrowserEvent('cemDeleted'); // Dispatch event after deletion

        // Optionally, you can reload the graves data after deletion
        $this->render();
    }

    public function render()
    {
        // Fetch graves data from the Graves model
        $graves = Graves::with('cemetery')->get();

        // Pass the fetched data to the view
        return view('livewire.show-burial-records', compact('graves'));
    }

    public function archive($id)
    {
        $record = BurialRecord::find($id);
        $record->archived_at = now();
        $record->save();
        $this->emit('recordArchived');
    }

}


