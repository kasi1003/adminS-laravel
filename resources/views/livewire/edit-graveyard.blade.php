<div>
    <div class="card w-75 m-3">
        <div class="card-header"> Edit Tables </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Cemetery Name</th>
                        <th scope="col">Town</th>
                        <th scope="col">Number Of Sections</th>
                        <th scope="col">Total Graves</th>
                        <th scope="col">Available Graves</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if ($cemeteries)
                    @foreach ($cemeteries as $cemetery)
                    <!-- Your table row content here -->
                    <tr>
                        <td>{{ $cemetery->CemeteryName }}</td>
                        <td>{{ $cemetery->Town }}</td>
                        <td>{{ $cemetery->NumberOfSections }}</td>
                        <td>{{ $cemetery->TotalGraves }}</td>
                        <td>{{ $cemetery->AvailableGraves }}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button wire:click="openEditModal({{ $cemetery->id }})" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
                                Edit
                            </button>
                            <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Cemetery</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @if ($showEditModal)
                                            <form>
                                                <div class="form-group">
                                                    <label for="CemeteryName">Cemetery Name</label>
                                                    <input wire:model="selectedCemetery.CemeteryName" type="text" class="form-control" id="CemeteryName">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Town">Town</label>
                                                    <input wire:model="selectedCemetery.Town" type="text" class="form-control" id="Town">
                                                </div>
                                                <div class="form-group">
                                                    <label for="NumberOfSections">Number of Sections</label>
                                                    <input wire:model="selectedCemetery.NumberOfSections" type="number" class="form-control" id="NumberOfSections">
                                                </div>
                                                <div class="form-group">
                                                    <label for="TotalGraves">Total Graves</label>
                                                    <input wire:model="selectedCemetery.TotalGraves" type="number" class="form-control" id="TotalGraves">
                                                </div>
                                                <div class="form-group">
                                                    <label for="AvailableGraves">Available Graves</label>
                                                    <input wire:model="selectedCemetery.AvailableGraves" type="number" class="form-control" id="AvailableGraves">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button wire:click="saveChanges" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                    @else
                    <p>No cemeteries found.</p>
                    @endif

                </tbody>

            </table>

        </div>
    </div>





</div>
