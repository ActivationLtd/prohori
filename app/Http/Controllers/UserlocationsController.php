<?php

namespace App\Http\Controllers;

use App\Clientlocation;
use App\User;
use App\Userlocation;
use DB;
use Request;
class UserlocationsController extends ModulebaseController
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
    // public function gridColumns() {
    //     return [
    //         //['table.id', 'id', 'ID'], // translates to => table.id as id and the last one ID is grid colum header
    //         ["{$this->module_name}.id", "id", "ID"],
    //         ["user.full_name", "user_full_name", "ID"],
    //         ["{$this->module_name}.latitude", "latitude", "Longitude"],
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
    public function sourceTables() {
        return DB::table($this->module_name)
            ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
            ->leftJoin('users as user', $this->module_name . '.user_id', 'user.id');
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
        // if (user()->inGroupId(7)) {
        //     $query = $query->where($this->module_name.'.client_id', user()->client_id);
        // }

        // Exclude deleted rows
        $query = $query->whereNull($this->module_name . '.deleted_at'); // Skip deleted rows

        return $query;
    }

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

    public function guardLocationFilter(){

        $division_id=$district_id=$upazila_id=$client_id=$clientlocationtype_id=$clientlocation_id=$guard_user_id=null;
        if(Request::has('division_id'))
        {
            $division_id=Request::get('division_id');
        }
        if(Request::has('district_id'))
        {
            $district_id=Request::get('district_id');
        }
        if(Request::has('upazila_id'))
        {
            $upazila_id=Request::get('upazila_id');
        }
        if(Request::has('client_id'))
        {
            $client_id=Request::get('client_id');
        }
        if(Request::has('clientlocationtype_id'))
        {
            $clientlocationtype_id=Request::get('clientlocationtype_id');
        }
        if(Request::has('clientlocation_id'))
        {
            $clientlocation_id=Request::get('clientlocation_id');
        }
        if(Request::has('guard_user_id'))
        {
            $guard_user_id=Request::get('guard_user_id');
        }
        $client_locations=Clientlocation::where('is_active',1)
            ->whereNull('deleted_at');

        if($division_id != 0){
            $client_locations=$client_locations->where('division_id',$division_id);
        }
        if($district_id != 0){
            $client_locations=$client_locations->where('district_id',$district_id);
        }
        if($upazila_id != 0){
            $client_locations=$client_locations->where('upazila_id',$upazila_id);
        }
        if($client_id != 0){
            $client_locations=$client_locations->where('client_id',$client_id);
        }
        if($clientlocation_id != 0){
            $client_locations=$client_locations->where('id',$clientlocation_id);
        }
        if($clientlocationtype_id != 0){
            $client_locations=$client_locations->where('clientlocationtype_id',$clientlocationtype_id);
        }


        $client_locations=$client_locations->pluck('id');

        $user_ids=User::whereIn('clientlocation_id',$client_locations)->where('group_ids_csv', '6');
        if($guard_user_id != 0){
            $user_ids=$user_ids->where('id',$guard_user_id);
        }
        $user_ids=$user_ids->get();

        return view('dashboards.admin.index',['users'=>$user_ids]);
        //return $user_ids;
        //$user_locations=Userlocation::whereIn('user_id',$user_ids)->get();



        //return $user_locations;

    }
}
