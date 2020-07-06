<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    protected $fillable = [ 'max', ];
    public $timestamps = false;

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'colissimos')->withPivot('price');
    }

}
