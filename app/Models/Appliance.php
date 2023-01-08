<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appliance extends Model
{
    use SoftDeletes;

    protected $table = 'appliances';
    protected $fillable = [
        'name',
        'description',
        'tension',
        'brand'
    ];
}
