<?php
namespace App\DataTables;
use App\Models\Page;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
class PagesDataTable extends DataTable
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
            ->addColumn('show', function ($page) {
                return '<a href="' . route('page', $page->slug) . '" class="btn btn-xs btn-info btn-block" target="_blank">Voir</a>';
            })
            ->addColumn('edit', function ($page) {
                return '<a href="' . route('pages.edit', $page->id) . '" class="btn btn-xs btn-warning btn-block">Modifier</a>';
            })
            ->addColumn('destroy', function ($page) {
                return '<a href="' . route('pages.destroy.alert', $page->id) . '" class="btn btn-xs btn-danger btn-block">Supprimer</a>';
            })
            ->rawColumns(['show', 'edit', 'destroy']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Page $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Page $model)
    {
        return $model->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('pages-table')
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
            Column::make('title')->title('Titre'),
            Column::make('slug')->title('Slug'),
            Column::computed('show')
              ->title('')
              ->width(60)
              ->addClass('text-center'),
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
        return 'Pages_' . date('YmdHis');
    }
}