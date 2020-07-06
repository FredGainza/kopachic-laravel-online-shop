<?php
namespace App\DataTables;
use App\Models\State;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
class StatesDataTable extends DataTable
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
            ->addColumn('edit', function ($state) {
                return '<a href="' . route('etats.edit', $state->id) . '" class="btn btn-xs btn-warning btn-block">Modifier</a>';
            })
            ->addColumn('destroy', function ($state) {
                return '<a href="' . route('etats.destroy.alert', $state->id) . '" class="btn btn-xs btn-danger btn-block ' . ($state->orders->count() ? 'disabled' : '') .'">Supprimer</a>';
            })
            ->editColumn('color', function ($state) {
                return '<i class="fas fa-square fa-lg text-' . config('colors.' . $state->color) . '"></i>';
            })
            ->rawColumns(['edit', 'destroy', 'color']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\State $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(State $model)
    {
        return $model->with('orders')->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('states-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->orderBy(5)
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
            Column::make('slug')->title('Slug'),
            Column::make('color')->title('Couleur')->addClass('text-center'),
            Column::make('indice')->title('indice'),
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
        return 'States_' . date('YmdHis');
    }
}