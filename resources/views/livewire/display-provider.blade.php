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
                        @foreach($serviceProviders as $provider)
                        <tr>
                            <td>{{ $provider->Name }}</td>
                            <td>{{ $provider->ContactNumber }}</td>
                            <td>{{ $provider->Email }}</td>
                            <td>
                                <button wire:click="editProvider({{ $provider->id }}) type=" button" class="btn btn-primary">Edit</button>
                                <button wire:click="deleteProvider({{ $provider->id }})" type="button" class="btn btn-danger">Delete</button>
                                <div wire:loading.remove wire:target="deleteProvider({{ $provider->id }})">
                                    <!-- Optionally, you can show a loading spinner or text -->
                                </div>

                            </td>

                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>