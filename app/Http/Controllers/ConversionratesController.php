<?php

namespace App\Http\Controllers;

class ConversionratesController extends ModulebaseController
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
            //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid column header
            ["{$this->module_name}.id", "id", "ID"],
            ["{$this->module_name}.updated_at", "updated_at", "Time"],
            ["{$this->module_name}.rate_u2e", "rate_u2e", "1 USD =? EUR"],
            ["{$this->module_name}.rate_u2g", "rate_u2g", "1 USD =? GBP"],
            ["{$this->module_name}.rate_e2u", "rate_e2u", "1 EUR =? USD"],
            ["{$this->module_name}.rate_e2g", "rate_e2g", "1 EUR =? GBP"],
            ["{$this->module_name}.rate_g2u", "rate_g2u", "1 GBP =? USD"],
            ["{$this->module_name}.rate_g2e", "rate_g2e", "1 GBP =? EUR"],
            // ["updater.name", "user_name", "Updater"],
            // ["{$this->module_name}.is_active", "is_active", "Active"]
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
        $dt = $dt->rawColumns(['id',  'is_active']); // HTML can be printed for raw columns

        // Next modify each column content
        $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
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


    /*
     * constructor
     */
    public function __construct()
    {
        $this->module_name = controllerModule(get_class());

        // Uncomment the following to define your own grid.
        // Also you can customize grid() function.
        // ***************************************************

        // // Define grid SELECT statement and HTML column name.
        $this->grid_columns = [
            //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid column header
            ["{$this->module_name}.id", "id", "ID"],
            ["{$this->module_name}.updated_at", "updated_at", "Time"],
            ["{$this->module_name}.rate_u2e", "rate_u2e", "1 USD =? EUR"],
            ["{$this->module_name}.rate_u2g", "rate_u2g", "1 USD =? GBP"],
            ["{$this->module_name}.rate_e2u", "rate_e2u", "1 EUR =? USD"],
            ["{$this->module_name}.rate_e2g", "rate_e2g", "1 EUR =? GBP"],
            ["{$this->module_name}.rate_g2u", "rate_g2u", "1 GBP =? USD"],
            ["{$this->module_name}.rate_g2e", "rate_g2e", "1 GBP =? EUR"],
            // ["updater.name", "user_name", "Updater"],

            // ["{$this->module_name}.is_active", "is_active", "Active"]
        ];
        //
        // // Construct SELECT statement
        // $select_cols = [];
        // foreach ($this->grid_columns as $col)
        //     $select_cols[] = $col[0] . ' as ' . $col[1];
        //
        // // Define Query for generating results for grid
        // $this->grid_query = \DB::table($this->module_name)
        //     ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
        //     ->select($select_cols);
        // ***************************************************

        parent::__construct($this->module_name);
    }


    // Custom grid function boilerplate.
    // ***************************************************
    /**
     * Returns datatable json for the module index page
     * A route is automatically created for all modules to access this controller function
     *
     * @var \Yajra\DataTables\DataTables $dt
     * @return mixed
     */
    public function grid()
    {
        // Construct SELECT statement
        $select_cols = [];
        foreach ($this->grid_columns as $col)
            $select_cols[] = $col[0] . ' as ' . $col[1];

        // Define Query for generating results for grid
        if (!isset($this->grid_query)) {
            $this->grid_query = \DB::table($this->module_name)
                ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
                ->select($select_cols);
        }
        // Inject tenant context in grid query
        if ($tenant_id = inTenantContext($this->module_name)) {
            $this->grid_query = injectTenantIdInModelQuery($this->module_name, $this->grid_query);
        }

        // Exclude deleted rows
        $this->grid_query = $this->grid_query->whereNull($this->module_name . '.deleted_at');

        // Make datatable
        $dt = datatables($this->grid_query);
        $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
        //$dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');

        // Columns for  HTML rendering
        $dt = $dt->rawColumns(['id', 'is_active']);

        return $dt->toJson();
    }
    // ***************************************************
}
