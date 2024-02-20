<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graves extends Model
{

    use HasFactory;
    protected $table = 'grave';

    protected $fillable = ['CemeteryID', 'SectionCode','GraveNum', 'GraveStatus', 'BuriedPersonsName', 'DateOfBirth','DateOfDeath', 'DeathCode'];


}
