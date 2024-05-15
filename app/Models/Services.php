<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $table = 'services';


    protected $fillable = ['ServiceName', 'Description', 'ProviderId', 'Price'];
    public function provider()
    {
        return $this->belongsTo(ServiceProvider::class, 'ProviderId', 'id');
    }
}


