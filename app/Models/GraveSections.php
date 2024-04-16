<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraveSections extends Model
{
    use HasFactory;

    protected $table = 'grave_sections';

    protected $primaryKey = 'id';

    protected $fillable = [
        'CemeteryID',
        'SectionCode',
        'Rows',
        'SectionType',
        'SectionSvg',
    ];

    // Define the relationship with cemetery
    public function cemetery()
    {
        return $this->belongsTo(Cemeteries::class, 'CemeteryID', 'CemeteryID');
    }
}
