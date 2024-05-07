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

                                <button wire:click.prevent="deleteCemetery({{ $cemetery->CemeteryID }})" class="btn btn-danger">Delete</button>
                                <button wire:click="viewSections({{ $cemetery->CemeteryID }})" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    View More
                                </button>



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
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Sections</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="addPrice">
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
                                        @if($section->Price)
                                        {{ $section->Price }}
                                        @else
                                        <input type="number" placeholder="Enter Price" wire:model="sectionPrices.{{ $section->id }}">
                                        <input type="hidden" wire:model="sectionIds.{{ $section->id }}" value="{{ $section->id }}">
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


            </div>
        </div>
    </div>


</div>