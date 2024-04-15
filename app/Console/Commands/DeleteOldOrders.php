<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;
use App\Models\Graves;
use Carbon\Carbon;

class DeleteOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
{
    // Log the current time
    Log::info('Current time: '.Carbon::now());

    $expirationTime = Carbon::now()->subMinutes(5);

    // Log a message indicating that the command is starting
Log::info('Deleting old orders started...');

// Delete old orders
$ordersToDelete = Orders::where('created_at', '<=', $expirationTime)->get();
$deletedCount = Orders::where('created_at', '<=', $expirationTime)->delete();

// Log the number of orders deleted
Log::info('Deleted '.$deletedCount.' old orders.');

// Log the created_at time of each order
foreach ($ordersToDelete as $order) {
    Log::info('Order created_at: '.$order->created_at);
}

// Enable query logging
DB::enableQueryLog();

// Update GraveStatus to null for corresponding graves
if ($deletedCount > 0) {
    $ordersToDelete->each(function ($order) {
        Graves::where([
            'CemeteryID' => $order->CemeteryID,
            'SectionCode' => $order->SectionCode,
            'RowID' => $order->RowID,
            'GraveNum' => $order->GraveNum
        ])->update(['GraveStatus' => null]);
    });
}

// Log database queries
Log::info(DB::getQueryLog());

// Log a message indicating that the command has finished
Log::info('Deleting old orders completed.');


    // Print a success message to the console
    $this->info('Old orders deleted successfully.');

    return 0;
}
}
