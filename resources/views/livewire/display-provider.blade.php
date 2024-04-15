<div style="width: 60%;">
    <div class="card mt-5" style="width: 100%;">
        <div class="card-header">Show Service Providers</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                                    <button wire:click="editProvider({{ $provider->id }}) type=" button"
                                        class="btn btn-primary">Edit</button>
                                    <button wire:click="deleteProvider({{ $provider->id }})" type="button"
                                        class="btn btn-danger">Delete</button>
                                    <!-- Button trigger modal -->
                                    <!-- Button trigger modal -->
                                    <button wire:click.prevent="viewServices({{ $provider->id }})" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">
                                        View Services
                                    </button>
                
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Service Name</th>
                                    <th scope="col">Service Description</th>
                                    <th scope="col">Service Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $service->ServiceName }}</td>
                                        <td>{{ $service->Description }}</td>
                                        <td>{{ $service->Price }}</td>
                                    </tr>
                                @endforeach
                                <tr>


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>


</div>
