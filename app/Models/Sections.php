<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;
    protected $table = 'grave_sections';
    protected $fillable = [
        'SectionID',
        'CemeteryID',
        'SectionCode',
        'TotalGraves',
        'AvailableGraves',


    ];
}
