<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Towns extends Model
{
    use HasFactory;
    protected $table = 'towns';
    protected $primaryKey = 'region_id';

    protected $fillable = [
        
        'region_id', 
        'name'
    ];
}
