<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'firstname', 'professionnal', 'civility', 'company', 'address', 'addressbis', 'bp', 'postal', 'city', 'phone', 'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
