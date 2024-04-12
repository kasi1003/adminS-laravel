<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminS;

class AdminController extends Controller
{
    
    public function grave_admin()
    {


        return view('graves.admin');
    }

    public function edit_graveyard()
    {


        return view('graves.edit');
    }
    public function burial_records()
    {


        return view('graves.records');
    }
    public function quotationsFun()
    {
        return view('graves.quotas');
    }
    

}
