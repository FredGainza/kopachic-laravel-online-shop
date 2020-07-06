<?php
namespace App\DataTables;
use App\Models\Address;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
class AddressesDataTable extends DataTable
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
            ->addColumn('show', function ($adresse) {
                return '<a href="' . route('back.adresses.show', $adresse->id) . '" class="btn btn-xs btn-warning btn-block">Voir</a>';
            })
            ->editColumn('country_id', function ($adresse) {
                return $adresse->country->name; 
            })
            ->rawColumns(['show']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Address $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Address $model)
    {
        return $model->with('country')->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('addresses-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->parameters([
                        'order' => [0, 'asc']
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
            Column::make('firstname')->title('Prénom'),
            Column::make('name')->title('Nom'),
            Column::make('company')->title('Raison sociale'), 
            Column::make('address')->title('Adresse'),            
            Column::make('postal')->title('Code postal'),
            Column::make('city')->title('Ville'),
            Column::make('country_id')->title('Pays'),
            Column::computed('show')
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
        return 'Addresses_' . date('YmdHis');
    }
}