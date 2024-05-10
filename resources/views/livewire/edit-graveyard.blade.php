<div style="width: 65%;">
    <div class="card mt-5">
        <div class="card-header">Display Cemeteries</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Cemetery Name</th>
                            <th scope="col">Town</th>
                            <th scope="col">Number Of Sections</th>
                            <th scope="col">Total Graves</th>
                            <th scope="col">Available Graves</th>
                            <th scope="col">Action Buttons</th>
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
                                <button wire:click="editCemetery({{ $cemetery->CemeteryID }})" type="button" class="btn btn-primary">Edit</button>

                                <button wire:click="deleteConfirm({{ $cemetery->CemeteryID }})" class="btn btn-danger">Delete</button>
                                <button wire:click="viewSections({{ $cemetery->CemeteryID }})" type="button" class="btn btn-success">View More</button>


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
    <script>
        window.addEventListener('confirmDelete', event => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',

            }).then((result) => {
                if (result.isConfirmed) {
                    // You can trigger another Livewire action or perform any other logic here
                    Livewire.emit('deleteGrave')
                }
            });
        });

        window.addEventListener('cemDeleted', event => {
            Swal.fire({
                title: "Deleted!",
                text: "Cemetery successfully deleted.",
                icon: "success"
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sections</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="addPrice">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Section</th>
                                    <th scope="col">Number of Rows</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $section)
                                <tr>
                                    <td>{{ $section->SectionCode }}</td>
                                    <td>{{ $section->Rows }}</td>
                                    <td>
                                        @if($editingSectionId == $section->id)
                                        <input type="number" placeholder="Enter Price" wire:model="sectionPrices.{{ $section->id }}">
                                        <input type="hidden" wire:model="sectionIds.{{ $section->id }}" value="{{ $section->id }}">
                                        <button class="btn btn-sm btn-primary" wire:click.prevent="savePrice({{ $section->id }})">Save</button>
                                        <button class="btn btn-sm btn-secondary" wire:click.prevent="cancelEdit">Cancel</button>
                                        @else
                                        
                                        @if(number_format($section->Price, 2))
                                        {{ number_format($section->Price, 2) }}                                        <button class="btn btn-sm btn-primary" wire:click.prevent="editPrice({{ $section->id }})">Edit</button>
                                        @else
                                        <button class="btn btn-sm btn-primary" wire:click.prevent="editPrice({{ $section->id }})">Add Price</button>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('showModal', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            });
        });
    </script>


</div>