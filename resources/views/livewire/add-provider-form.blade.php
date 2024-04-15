<div style="width: 40%">
    <div class="card mt-5" style="width: 100%;">
        <div class="card-header">Create Service Provider</div>

        <div class="card-body">
            <form wire:submit="addProvider">

                <div class="mb-3 d-flex flex-column">
                    <label for="name" class="form-label">Service Provider Name</label>
                    <input type="text" wire:model="name" placeholder="Enter Service Provider Name">
                </div>
                <div class="mb-3 d-flex flex-column">
                    <label for="motto" class="form-label">Service Provider Motto</label>
                    <input type="text" wire:model="motto" placeholder="Enter Service Provider Motto">
                </div>
                <div class="mb-3 d-flex flex-column">
                    <label for="email" class="form-label">Service Provider Email</label>
                    <input type="text" wire:model="email" placeholder="Enter Service Provider Email">
                </div>

                <div class="mb-3 d-flex flex-column">
                    <label for="cellphoneNumber" class="form-label">Service Provider Contact Number</label>
                    <input type="number" wire:model="cellphoneNumber" placeholder="Enter Service Provider Number">
                </div>


                <div class="mb-3 d-flex flex-column">
                    <label for="numberOfServices" class="form-label">Number of Services</label>
                    <input type="number" wire:model="numberOfServices" placeholder="Enter Number of Services">
                </div>

                @if($numberOfServices > 0)

                <div class="mb-3 d-flex flex-column">
                    @for($i = 0; $i < $numberOfServices; $i++) <div class="mb-3 d-flex flex-column">
                        <label for="service{{$i}}" class="form-label">Service {{$i+1}} Name</label>
                        <input type="text" wire:model="serviceNames.{{$i}}" placeholder="Enter Service Name" id="service{{$i}}">

                        @if(isset($showServiceDescription[$i]) && $showServiceDescription[$i]) 
                        <label for="serviceDescriptions{{$i}}" class="form-label">Product Description for Service {{$i+1}}</label>
                        <input type="text" wire:model="serviceDescriptions.{{$i}}" placeholder="Enter Product Description" id="description{{$i}}">
                        <!-- Generate input for product price -->
                        <label for="servicePrices{{$i}}" class="form-label">Product Price for Service {{$i+1}}</label>
                        <input type="number" wire:model="servicePrices.{{$i}}" placeholder="Enter Product Price" id="price{{$i}}">

                        @endif


                </div>
                @endfor
        </div>
        @endif

        <div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>
        </form>
    </div>
</div>
</div>