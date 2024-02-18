<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cemeteries extends Model
{
    use HasFactory;
    protected $table = 'cemetery';
    protected $fillable = ['CemeteryID', 'CemeteryName', 'Town', 'NumberOfSections', 'TotalGraves', 'AvailableGraves', 'SvgMap'];

}
