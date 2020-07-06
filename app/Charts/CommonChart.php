<?php
namespace App\Charts;
use ConsoleTVs\Charts\BaseChart;
use Chartisan\PHP\Chartisan;
abstract class CommonChart extends BaseChart
{
    protected function chartisan($model, $title)
    {
        $year = request()->year;
        $datas = $this->datas($year, $model);
        return Chartisan::build()
            ->labels($datas->pluck('month_name')->toArray())
            ->dataset($title , $datas->pluck('data')->toArray());
    }
    protected function datas($year, $model)
    {
        return $model->selectRaw('
            count(*) data, 
            month(created_at) month, 
            monthname(created_at) month_name
        ')
        ->whereYear('created_at', $year)
        ->groupBy('month', 'month_name')
        ->orderBy('month', 'asc')
        ->get();
    }
}