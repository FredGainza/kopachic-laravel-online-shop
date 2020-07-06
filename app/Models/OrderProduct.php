<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'name', 'total_price_gross', 'quantity',
    ];
    public $timestamps = false;
}
