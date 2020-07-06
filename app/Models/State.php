<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'color', 'indice',
    ];

    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
