<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cemeteries extends Model
{
    use HasFactory;
    protected $table = 'cemetery';
    protected $primaryKey = 'CemeteryID';
    protected $fillable = ['CemeteryName', 'Town', 'NumberOfSections', 'TotalGraves', 'AvailableGraves', 'SvgMap'];

     // Define the relationship with sections
     public function sections()
     {
         return $this->hasMany(Sections::class, 'CemeteryID', 'CemeteryID');
     }
}
