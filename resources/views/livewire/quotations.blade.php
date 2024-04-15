<div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Quotation Number</th>
                    <th scope="col">Actions</th> <!-- Add a column for actions -->
                </tr>
            </thead>
            <tbody>
                <!-- Iterate over orders and display UserId -->
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->UserId }}</td>
                    <td>
                        <!-- Button to trigger PDF generation -->
                        <form action="{{ route('generate-pdf', ['userId' => $order->UserId]) }}" method="POST" target="_blank">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Generate PDF</button>
                        </form>

                        <!-- Button to approve -->
                        <form action="{{ route('approve-order', ['userId' => $order->UserId]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

