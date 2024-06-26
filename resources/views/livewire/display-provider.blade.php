<div style="width: 60%;">
    <div class="card mt-5" style="width: 100%;">
        <div class="card-header">Show Service Providers</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Service Provider Name</th>
                            <th scope="col">Contact Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($serviceProviders as $provider)
                        <tr>
                            <td>{{ $provider->Name }}</td>
                            <td>{{ $provider->ContactNumber }}</td>
                            <td>{{ $provider->Email }}</td>
                            <td>
                                <button wire:click="editProvider({{ $provider->id }})" type="button" class="btn btn-primary">Edit</button>

                                <!-- Button trigger modal -->
                                <button wire:click="deleteConfirm({{ $provider->id }})" class="btn btn-danger">Delete</button>

                                <button wire:click="viewServices({{ $provider->id }})" type="button" class="btn btn-success">View Services</button>



                            </td>

                        </tr>
                        @endforeach
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
                    Livewire.emit('deleteProvider')
                }
            });
        });

        window.addEventListener('cemDeleted', event => {
            Swal.fire({
                title: "Deleted!",
                text: "Service Provider successfully deleted.",
                icon: "success"
            });
        });
        document.addEventListener('livewire:load', function() {
            Livewire.on('openViewServicesModal', function() {
                var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Services</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ProviderName</th>

                                    <th scope="col">Service Name</th>
                                    <th scope="col">Service Description</th>
                                    <th scope="col">Service Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                <tr>
                                    <td>{{ $provider->Name }}</td>
                                    <td>{{ $service->ServiceName }}</td>
                                    <td>{{ $service->Description }}</td>
                                    <td>{{ $service->Price }}</td>
                                </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    









</div>