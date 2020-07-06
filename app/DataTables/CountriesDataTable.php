<?php

namespace App\DataTables;

use App\Models\Country;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CountriesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('edit', function ($country) {
                return '<a href="' . route('pays.edit', $country->id) . '" class="btn btn-xs btn-warning btn-block">Modifier</a>';
            })
            ->addColumn('destroy', function ($country) {
                return '<a href="' . route('pays.destroy.alert', $country->id) . '" class="btn btn-xs btn-danger btn-block ' . ($country->ranges->count() || $country->addresses->count() || $country->order_addresses->count() ? 'disabled' : '') .'">Supprimer</a>';
            })
            ->rawColumns(['edit', 'destroy']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Country $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
    {
        return $model->with('ranges', 'addresses', 'order_addresses')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('countries-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->parameters([
                        'order' => [1, 'asc']
                    ])
                    ->lengthMenu()
                    ->language('//cdn.datatables.net/plug-ins/1.10.20/i18n/French.json');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name')->title('Nom'),
            Column::make('tax')->title('Taxe'),
            Column::computed('edit')
              ->title('')
              ->width(60)
              ->addClass('text-center'),
            Column::computed('destroy')
              ->title('')
              ->width(60)
              ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Countries_' . date('YmdHis');
    }
}
