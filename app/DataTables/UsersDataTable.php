<?php
namespace App\DataTables;
use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UsersDataTable extends DataTable
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
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('d/m/Y');
            })
            ->editColumn('principale', function ($user) {
                $adress = DB::table('addresses')->find($user->principale);
                $pays = DB::table('countries')->find($adress->country_id);
                if($adress->professionnal == 0){
                    $addPrincipale = $adress->civility. ' ' . $adress->firstname. ' ' .strtoupper($adress->name) . ' ' .$adress->address. ($adress->addressbis ? ' '.$adress->addressbis. ' ' : ''). ' - ' .strtoupper($adress->city). ' (' .$pays->name. ')';
                }else{
                    $addPrincipale = strtoupper($adress->company). ' ' .$adress->address. ($adress->addressbis ? ' '.$adress->addressbis. ' ' : ''). ' - ' .strtoupper($adress->city). ' (' .$pays->name. ')';
                }
                return $addPrincipale; 
            })
            ->addColumn('action', function ($user) {
                return '<a href="' . route('clients.show', $user->id) . '" class="btn btn-xs btn-info btn-block">Voir</a>';
            })
            ->editColumn('newsletter', function ($user) {
                return $user->newsletter ? '<i class="fas fa-check text-success"></i>' : ''; 
            })
            ->addColumn('online', function ($user) {
                return (Cache::has('user-is-online-' . $user->id)) ? '<i class="fas fa-check text-success"></i>' : ''; 
            })
            ->addColumn('last', function ($user) {
                return $user->last_seen ? $user->last_seen->calendar() : ''; 
            })
            ->rawColumns(['newsletter', 'online', 'last', 'action']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->whereAdmin(false)->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('users-table')
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
            Column::make('firstname')->title('Prénom'),
            Column::make('email'),
            Column::make('newsletter')->title('Lettre d\'information')->addClass('text-center'),
            Column::make('created_at')->title('Inscription'),
            Column::make('principale')->title('Adresse principale'),
            Column::computed('online')
                  ->title('En ligne')
                  ->width(60)
                  ->addClass('text-center'),
            Column::computed('last')
                  ->title('Dernier vu')
                  ->width(100)
                  ->addClass('text-center'),
            Column::computed('action')
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
        return 'Users_' . date('YmdHis');
    }
}