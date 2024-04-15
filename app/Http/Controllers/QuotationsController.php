<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class QuotationsController extends Controller
{
    public function approveOrder(Request $request, $userId)
    {
        // Logic to delete the order records associated with the given $userId
        Orders::where('UserId', $userId)->delete();

        // Redirect back to the page after deleting the orders
        return back()->with('success', 'Order approved successfully.');
    }
}

