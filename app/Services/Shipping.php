<?php
namespace App\Services;
use App\Models\Range;
use Cart;


class Shipping
{
    public function compute($country_id)
    {
        $items = Cart::getContent();
        $weight = $items->sum(function ($item) {
            return $item->quantity * $item->model->weight;
        });
        $range = Range::orderBy('max')->where('max', '>=', $weight)->first();
        
        return $range->countries()->where('countries.id', $country_id)->first()->pivot->price;
    }
}