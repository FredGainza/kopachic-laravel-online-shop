<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use Illuminate\Http\Request;
use App\Models\Order;

class OrdersChart extends CommonChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        return $this->chartisan(new Order, 'Commandes');
    }
}