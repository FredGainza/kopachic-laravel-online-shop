<?php
namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class StatisticsController extends Controller
{
    public function __invoke(Request $request)
    {  
        $actualYear = $request->year;
        // Années disponibles
        $years = range(Order::oldest()->first()->created_at->year, now()->year);
        return view('back.statistics.index', compact(
            'years',
            'actualYear'
        ));
    }
}
