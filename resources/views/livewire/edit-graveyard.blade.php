<div>
    <div class="card w-75 m-3 mx-auto">
        <div class="card-header"> Edit Tables </div>
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
                            <button wire:click="redirectToAdminPage({{ $cemetery->CemeteryID }})" type="button" class="btn btn-primary">Edit</button>

                            <button wire:click="deleteCemetery({{ $cemetery->CemeteryID }})" class="btn btn-danger">Delete</button>

                           
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
