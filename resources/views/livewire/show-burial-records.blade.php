<div>
    <div class="card mt-5" style="width: 100%;">
        <div class="card-header">Display Burial Records</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Cemetery Name</th>
                            <th scope="col">Section</th>
                            <th scope="col">Row ID</th>
                            <th scope="col">Grave Number</th>
                            <th scope="col">Buried Persons Name</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Date of Death</th>
                            <th scope="col">Death Code</th>
                            <th scope="col">Action Buttons</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($graves as $grave)
                        <tr>
                            <td>{{ $grave->cemetery->CemeteryName }}</td>
                            <td>{{ $grave->SectionCode }}</td>
                            <td>{{ $grave->RowID }}</td>
                            <td>{{ $grave->GraveNum }}</td>
                            <td>{{ $grave->BuriedPersonsName }}</td>
                            <td>{{ $grave->DateOfBirth }}</td>
                            <td>{{ $grave->DateOfDeath }}</td>
                            <td>{{ $grave->DeathCode }}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button wire:click="" type="button" class="btn btn-primary">Edit</button>
                                <!-- Inside your Blade file or Livewire component view -->
                                <button wire:click="deleteConfirm({{ $grave->id }})" type="button" class="btn btn-danger">Delete</button>
                                <button wire:click="archive({{ $grave->id }})" type="button" class="btn btn-secondary">Archive</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Inside your Livewire component view -->
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
                    Livewire.emit('deleteRecord')
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
</div>
