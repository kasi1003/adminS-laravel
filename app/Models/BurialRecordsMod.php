<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BurialRecordsMod extends Model
{
    use HasFactory;
    protected $table = 'burial_records';
    protected $fillable = [
        'GraveNumber',
        'CemeteryID',
        'SectionCode',
        'Surname',
        'Name',
        'DateOfBirth',
        'DateOfDeath',
        'DeathNumber',

    ];
}
