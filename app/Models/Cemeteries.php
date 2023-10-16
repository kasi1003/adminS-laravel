<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cemeteries extends Model
{
    use HasFactory;
    protected $table = 'cemeteries';
    protected $fillable = [
        'CemeteryID',
        'Region',
        'CemeteryName',
        'Town',

    ];
}
