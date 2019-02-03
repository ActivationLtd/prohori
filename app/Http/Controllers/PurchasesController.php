<?php

namespace App\Http\Controllers;

use DB;

class PurchasesController extends ModulebaseController
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
            ["{$this->module_name}.product_title", "product_title", "<span style='width:300px'>Product</span>"],
            ["{$this->module_name}.product_sku", "product_sku", "SKU"],
            ["{$this->module_name}.product_order_id", "product_order_id", "Order"],
            ["partner.name", "partner_name", "Partner"],
            ["{$this->module_name}.charity_name", "charity_name", "Charity"],
            // ["updater.name", "user_name", "Updater"],
            ["{$this->module_name}.product_price_in_lb_currency", "product_price_in_lb_currency", "Price"],
            ["{$this->module_name}.user_commission_in_lb_currency", "user_commission_in_lb_currency", "User"],
            ["{$this->module_name}.charity_donation_in_lb_currency", "charity_donation_in_lb_currency", "Charity"],
            ["{$this->module_name}.lb_commission_in_lb_currency", "lb_commission_in_lb_currency", "LB"],
            // ["{$this->module_name}.updated_at", "updated_at", "Time"],
            ["{$this->module_name}.status", "status", "Status"]
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
    public function sourceTables()
    {
        return DB::table($this->module_name)
            ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
            ->leftJoin('partners as partner', $this->module_name . '.partner_id', 'partner.id')
            ->leftJoin('recommendurls as recommendurl', $this->module_name . '.recommendurl_id', 'recommendurl.id');
    }

    /**
     * Define Query for generating results for grid
     *
     * @return $this|mixed
     */
    public function gridQuery()
    {
        $query = $this->sourceTables()->select($this->selectColumns());

        // Inject tenant context in grid query
        if ($tenant_id = inTenantContext($this->module_name)) {
            $query = injectTenantIdInModelQuery($this->module_name, $query);
        }

        // Exclude deleted rows
        $query = $query->whereNull($this->module_name . '.deleted_at'); // Skip deleted rows

        // Only show entries from the same partner
        if (user()->partner_id) {
            $query = $query->where("{$this->module_name}.partner_id", user()->partner_id); // Skip deleted rows
        }

        return $query;
    }

    /**
     * Modify datatable values
     *
     * @return mixed
     */
    public function datatableModify($dt)
    {
        // First set columns for  HTML rendering
        /** @var  $dt \Yajra\DataTables\DataTableAbstract $dt */
        $dt = $dt->escapeColumns(['product_title', 'id', 'is_active']); // HTML can be printed for raw columns
        $dt = $dt->rawColumns(['id', 'is_active']); // HTML can be printed for raw columns

        // Next modify each column content
        $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
        $dt = $dt->editColumn('product_price_in_lb_currency', '&pound; {{ money($product_price_in_lb_currency) }}');
        $dt = $dt->editColumn('user_commission_in_lb_currency', '&pound; {{ money($user_commission_in_lb_currency) }}');
        $dt = $dt->editColumn('charity_donation_in_lb_currency', '&pound; {{ money($charity_donation_in_lb_currency) }}');
        $dt = $dt->editColumn('lb_commission_in_lb_currency', '&pound; {{ money($lb_commission_in_lb_currency) }}');
        // $dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');

        return $dt;
    }

    /**
     * Returns datatable json for the module index page
     * A route is automatically created for all modules to access this controller function
     *
     * @var \Yajra\DataTables\DataTables $dt
     * @return \Illuminate\Http\JsonResponse
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

}
