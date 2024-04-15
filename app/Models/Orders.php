<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders'; // Specify the table name if it's different from the model name in lowercase and plural

    protected $fillable = [
        'UserId',
        'CemeteryID',
        'SectionCode',
        'RowID',
        'GraveNum',
        'BuyerName',
        'Email',
        'IdNumber',
        'PhoneNumber',
        // Add other fillable fields as needed
    ];
}