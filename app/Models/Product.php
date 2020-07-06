<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'quantity', 'weight', 'active', 'quantity_alert', 'image', 'description', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
