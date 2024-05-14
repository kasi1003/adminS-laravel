<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graves extends Model
{

    use HasFactory;
    protected $table = 'grave';

    protected $fillable = ['CemeteryID', 'SectionCode', 'RowID', 'GraveNum', 'Price', 'GraveStatus', 'BuriedPersonsName', 'DateOfBirth', 'DateOfDeath', 'DeathCode'];
    public function cemetery()
    {
        return $this->belongsTo(Cemeteries::class, 'CemeteryID', 'CemeteryID');
    }
}

