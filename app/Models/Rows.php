<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rows extends Model
{
    use HasFactory;
    protected $table = 'rows';
    protected $fillable = [
        
        'CemeteryID',
        'SectionCode',
        'RowID',
        'AvailableGraves',
        'TotalGraves'
    ];


}
