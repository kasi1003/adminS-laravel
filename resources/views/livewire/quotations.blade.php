<div>
<<<<<<< Updated upstream
    <div class="card w-75 m-3 mx-auto">
        <div class="card-header"> Quotations </div>
        <div class="card-body">

            
        </div>


    </div>

=======
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Quotation Number</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iterate over orders and display UserId -->
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->UserId }}</td>
                    <td>
                        <!-- Button trigger modal -->
                        <button wire:click="viewFullQuotation" type="button" class="btn btn-primary">View Full Quotation</button>

                        <button wire:click="deleteQuotation" class="btn btn-danger">Delete Quotation</button>
>>>>>>> Stashed changes

                        <button wire:click="approveQuotation" class="btn btn-success">Approve Quotation</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
