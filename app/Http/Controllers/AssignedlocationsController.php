<?php

namespace App\Http\Controllers;

class AssignedlocationsController extends ModulebaseController
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
    // public function gridColumns()
    // {
    //     return [
    //         //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
    //         ["{$this->module_name}.id", "id", "ID"],
    //         ["{$this->module_name}.name", "name", "Name"],
    //         ["updater.name", "user_name", "Updater"],
    //         ["{$this->module_name}.updated_at", "updated_at", "Updated at"],
    //         ["{$this->module_name}.is_active", "is_active", "Active"]
    //     ];
    // }

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
    // public function datatableModify($dt)
    // {
    //     // First set columns for  HTML rendering
    //     $dt = $dt->rawColumns(['id', 'name', 'is_active']); // HTML can be printed for raw columns
    //
    //     // Next modify each column content
    //     $dt = $dt->editColumn('name', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$name}}</a>');
    //     $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
    //     $dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');
    //
    //     return $dt;
    // }

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

    /**
     * In Controller store(), update() before filling the model input values are
     * transformed. Usually it is a good approach for converting arrays to json.
     *
     *
     * @param array $inputs
     * @return array
     */
    // public function transformInputs($inputs = [])
    // {
    //     /*
    //      * Convert an array input to csv
    //      ************************************************/
    //     // $arr_to_csv_inputs = [
    //     //     'partnercategory_ids'
    //     // ];
    //     //
    //     // foreach ($arr_to_csv_inputs as $i){
    //     //     if(isset($inputs[$i]) && is_array($inputs[$i])){
    //     //         $inputs[$i] = arrayToCsv($inputs[$i]);
    //     //     }else{
    //     //         $inputs[$i] = null;
    //     //     }
    //     // }
    //
    //     /*
    //      * Convert an array input to json
    //      ************************************************/
    //     $arr_to_json_inputs = [
    //         'field1_ids',
    //         'field2_ids',
    //     ];
    //
    //     foreach ($arr_to_json_inputs as $i) {
    //         if (isset($inputs[$i]) && is_array($inputs[$i])) {
    //             $inputs[$i] = json_encode($inputs[$i]);
    //         } else {
    //             $inputs[$i] = null;
    //         }
    //     }
    //
    //     return $inputs;
    // }
    // ****************** transformInputs functions end ***********************
}
