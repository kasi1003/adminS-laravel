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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceProviders as $provider)
                        <tr>
                            <td>{{ $provider->Name }}</td>
                            <td>{{ $provider->ContactNumber }}</td>
                            <td>{{ $provider->Email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>