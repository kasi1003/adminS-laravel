<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AdminController;
class adminS extends Model
{
    use HasFactory;
    protected $table = 'regions'; // Match the table name
    
    public function towns()
    {
        return $this->hasMany(Town::class, 'region_id');
    }
}
