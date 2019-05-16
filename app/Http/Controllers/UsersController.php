<?php

namespace App\Http\Controllers;

use App\Upload;
use App\User;
use Hash;
use Request;
use Session;
use Validator;

class UsersController extends ModulebaseController
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
            ["{$this->module_name}.email", "email", "Email"],
            ["{$this->module_name}.group_titles_csv", "group_titles_csv", "Group"],
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
    public function transformInputs($inputs = [])
    {
        /*
         * Convert an array input to csv
         ************************************************/
        // $arr_to_csv_inputs = [
        //     'partnercategory_ids'
        // ];
        //
        // foreach ($arr_to_csv_inputs as $i){
        //     if(isset($inputs[$i]) && is_array($inputs[$i])){
        //         $inputs[$i] = arrayToCsv($inputs[$i]);
        //     }else{
        //         $inputs[$i] = null;
        //     }
        // }

        /*
         * Convert an array input to json
         ************************************************/
        $arr_to_json_inputs = [
            'group_ids',
        ];

        foreach ($arr_to_json_inputs as $i) {
            if (isset($inputs[$i]) && is_array($inputs[$i])) {
                $inputs[$i] = json_encode($inputs[$i]);
            }

        }

        return $inputs;
    }

    // ****************** transformInputs functions end ***********************

    public function store()
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        $module_name = $this->module_name;
        $Model = model($this->module_name);

        //$element_name = str_singular($module_name);
        //$ret = ret();
        # --------------------------------------------------------
        # Process store while creation
        # --------------------------------------------------------
        $validator = null;
        $inputs = $this->transformInputs(Request::all());
        $element = new $Model($inputs);
        if (hasModulePermission($this->module_name, 'create')) { // check module permission
            $validator = Validator::make(Request::all(), $Model::rules($element), $Model::$custom_validation_messages);

            // $element = new $Model;
            // $element->fill(Request::all());
            // $validator = $element->validateModel();

            if ($validator->fails()) {
                $ret = ret('fail', "Validation error(s) on creating {$this->module->title}.", ['validation_errors' => json_decode($validator->messages(), true)]);
            } else {
                if ($element->isCreatable()) {

                    /************************************************************************
                     * If there is a password Hash it. And set a lfag just_changed_password
                     */
                    if (Request::get('password') !== null) {
                        $element->password = Hash::make(Request::get('password'));
                    }

                    // Generate new api token
                    if (Request::get('api_token_generate') === 'yes') {
                        $element->api_token = hash('sha256', randomString(10), false);
                    }

                    if ($element->save()) {
                        //$ret = ret('success', "$Model " . $element->id . " has been created", ['data' => $Model::find($element->id)]);
                        $ret = ret('success', "{$this->module->title} has been added", ['data' => $Model::find($element->id)]);
                        Upload::linkTemporaryUploads($element->id, $element->uuid);
                    } else {
                        $ret = ret('fail', "{$this->module->title} create failed.");
                    }
                } else {
                    $ret = ret('fail', "{$this->module->title} could not be saved. (error: isCreatable())");
                }
            }
        } else {
            $ret = ret('fail', "User does not have create permission for {$this->module->title} ");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        return $this->jsonOrRedirect($ret, $validator, $element);
    }

    /**
     * Update handler for spyr element.
     *
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        /**
         * @var \App\User $Model
         * @var \App\User $element
         */
        $Model = model($this->module_name);
        $ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process update
        # --------------------------------------------------------
        $validator = null;
        if ($element = $Model::find($id)) { // Check if element exists.
            if ($element->isEditable()) { // Check if the element is editable.

                /******************************************************************************************
                 * Differently handled validation due to password, password_confirmation.
                 * - All password input must be paired with password_confirmation and go through validation.
                 * - User can be updated without password in input, in that case old password will retain.
                 */

                //dd(array_merge($element->getAttributes(), Request::all()));

                $validator = Validator::make(array_merge($element->getAttributes(), Request::all()), $Model::rules($element), $Model::$custom_validation_messages);
                //$validator = $element->validateModel();
                /******************************************************************************************/

                if ($validator->fails()) {
                    $ret = ret('fail', "Validation error(s) on updating {$this->module->title}.", ['validation_errors' => json_decode($validator->messages(), true)]);
                } else {

                    $element->fill($this->transformInputs(Request::all()));

                    /************************************************************************
                     * If there is a password Hash it. And set a lfag just_changed_password
                     */
                    if (Request::get('password') !== null) {
                        $element->password = Hash::make(Request::get('password'));
                        if ($element->last_login_at) {
                            Session::push('just_changed_password', 1);
                        }
                    } else {
                        $element->password = $element->getOriginal('password');
                    }

                    // Generate new api token
                    if (Request::get('api_token_generate') === 'yes') {
                        $element->api_token = hash('sha256', randomString(10), false);
                    }
                    /************************************************************************/

                    if ($element->save()) { // Attempt to update/save.
                        $ret = ret('success', "{$this->module->title} has been updated", ['data' => $element]);
                    } else { // attempt to update/save failed. Set error message and return values.
                        $ret = ret('fail', "{$this->module->title} update failed.");
                    }
                }

            } else { // Element is not editable. Set message and return values.
                $ret = ret('fail', "{$this->module->title} is not editable by user.");
            }
        } else { // element does not exist(or possibly deleted). Set error message and return values
            $ret = ret('fail', "{$this->module->title} could not be found. The element is either unavailable or deleted.");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        return $this->jsonOrRedirect($ret, $validator, $element);
    }
    public function customWatcher(){
        if(Request::has('id')){
            $id=Request::get('id');
            $user=User::find($id);
            return $user;
        }
    }
}
