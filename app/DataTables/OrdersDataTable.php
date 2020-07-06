<?php
namespace App\DataTables;
use App\Models\Order;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
class OrdersDataTable extends DataTable
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
            ->editColumn('created_at', function ($order) {
                return $order->created_at->format('d/m/Y');
            })
            ->editColumn('updated_at', function ($order) {
                return $order->updated_at->format('d/m/Y');
            })
            ->editColumn('total', function ($order) {
                return number_format($order->totalOrder, 2, ',', ' ') . ' €';
            })
            ->editColumn('payment', function ($order) {
                return $order->payment_text;
            })
            ->editColumn('state_id', function ($order) {
                return '<span class="badge badge-' . config('colors.' . $order->state->color) . '">' . $order->state->name . '</span>';
            })
            ->orderColumn('state_id', '-state_id $1')
            ->addColumn('client', function ($order) {
                return '<a href="' . route('clients.show', $order->user->id) . '">' . $order->user->name . ' ' . $order->user->firstname . '</a>';
            })
            ->editColumn('invoice_id', function ($order) {
                return $order->invoice_id ? '<i class="fas fa-check text-success"></i>' : '';
            })
            ->addColumn('action', function ($order) {
                return '<a href="' . route('orders.show', $order->id) . '" class="btn btn-xs btn-info btn-block">Voir</a>';
            })
            ->rawColumns(['client', 'state_id', 'invoice_id', 'action']);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        return $model->with('state', 'user')->newQuery();
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('orders-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Blfrtip')
                    ->parameters([
                        'order' => [7, 'desc']
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
            Column::make('reference')->title('Référence'),
            Column::computed('client')->title('Client'),
            Column::make('total')->title('Total'),
            Column::make('payment')->title('Paiement'),
            Column::make('state_id')->title('Etat'),
            Column::make('invoice_id')->title('Facture')->addClass('text-center'),
            Column::make('created_at')->title('Date'),
            Column::make('updated_at')->title('Changement'),
            Column::computed('action')->title('')->width(60)->addClass('text-center'),
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Orders_' . date('YmdHis');
    }
}