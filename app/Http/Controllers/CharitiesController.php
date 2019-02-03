<?php

namespace App\Http\Controllers;

use App\Charity;
use App\Invoice;
use App\Purchase;

class CharitiesController extends ModulebaseController
{

    /*********************************************************************
     * Grid related functions.
     * Uncomment the functions to show modified grid.
     ********************************************************************/

    /**
     * Define grid SELECT statement and HTML column name.
     *
     * @return array
     */
    public function gridColumns()
    {
        return [
            //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
            ["{$this->module_name}.id", "id", "ID"],
            ["{$this->module_name}.name", "name", "Name"],
            ["{$this->module_name}.order", "order", "Order"],
            ["{$this->module_name}.is_published", "is_published", "Published?"],
            ["updater.name", "user_name", "Updater"],
            ["{$this->module_name}.updated_at", "updated_at", "Updated at"],
            ["{$this->module_name}.is_active", "is_active", "Active"]
        ];
    }

    /**
     * Construct SELECT statement based
     *
     * @return array
     */
    // public function selectColumns()
    // {
    //     $select_cols = [];
    //     foreach ($this->gridColumns() as $col)
    //         $select_cols[] = $col[0] . ' as ' . $col[1];
    //
    //     return $select_cols;
    // }

    /**
     * Define Query for generating results for grid
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    // public function sourceTables()
    // {
    //     return DB::table($this->module_name)
    //         ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id');
    // }

    /**
     * Define Query for generating results for grid
     *
     * @return $this|mixed
     */
    // public function gridQuery()
    // {
    //     $query = $this->sourceTables()->select($this->selectColumns());
    //
    //     // Inject tenant context in grid query
    //     if ($tenant_id = inTenantContext($this->module_name)) {
    //         $query = injectTenantIdInModelQuery($this->module_name, $query);
    //     }
    //
    //     // Exclude deleted rows
    //     $query = $query->whereNull($this->module_name . '.deleted_at'); // Skip deleted rows
    //
    //     return $query;
    // }

    /**
     * Modify datatable values
     *
     * @var $dt \Yajra\DataTables\DataTableAbstract
     * @return mixed
     */
    public function datatableModify($dt)
    {
        // First set columns for  HTML rendering
        $dt = $dt->rawColumns(['id', 'name', 'is_active']); // HTML can be printed for raw columns

        /* @var $dt \Yajra\DataTables\DataTableAbstract */
        // Next modify each column content
        $dt = $dt->editColumn('name', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$name}}</a>');
        $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
        $dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');
        $dt = $dt->editColumn('is_published', '@if($is_published)  Yes @else No @endif');

        return $dt;
    }

    /**
     * Returns datatable json for the module index page
     * A route is automatically created for all modules to access this controller function
     *
     * @var \Yajra\DataTables\DataTables $dt
     * @return string
     */
    // public function grid()
    // {
    //     // Make datatable
    //     /** @var \Yajra\DataTables\DataTableAbstract $dt */
    //     $dt = datatables($this->gridQuery());
    //     $dt = $this->datatableModify($dt);
    //     return $dt->toJson();
    // }

    // ****************** Grid functions end *********************************

    /**
     * @param \App\Charity $charity
     * @return string
     */
    public function invoices(Charity $charity)
    {
        if ($charity->isViewable()) {

            $purchases_not_invoiced = Purchase::with(['recommender', 'partner'])
                ->where('charity_id', $charity->id)
                //->where('is_approved','=',1)
                //->where('charity_donation_charity_currency', '>', 0)
                ->whereNull('charity_invoice_id')
                ->orderBy('created_at', 'asc')
                ->get();

            $invoices = Invoice::with(['recommender', 'partner'])->where('charity_id', $charity->id)
                ->orderBy('created_at', 'asc')
                ->get();

            return view('modules.charities.invoices')
                ->with('purchases_not_invoiced', $purchases_not_invoiced)
                ->with('invoices', $invoices)
                ->with('charity', $charity)
                ->with('grid_columns', $this->gridColumns());
        }
        return 'Permission denied';
    }

}
