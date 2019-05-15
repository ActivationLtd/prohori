<?php

namespace App\Http\Controllers;
use DB;
use Request;
use App\Task;
use Response;
use Lang;
class TasksController extends ModulebaseController
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
            ["{$this->module_name}.id", "id", Lang::get('messages.Id')],
            ["{$this->module_name}.name", "name", Lang::get('messages.Name')],
            ["{$this->module_name}.tasktype_name", "tasktype_name", Lang::get('messages.Type')],
            ["{$this->module_name}.client_name", "client_name",Lang::get('messages.Client')],
            ["{$this->module_name}.clientlocation_name", "clientlocation_name", Lang::get('messages.Client-location')],
            ["{$this->module_name}.due_date", "due_date", Lang::get('messages.Due-date')],
            ["{$this->module_name}.priority", "priority", Lang::get('messages.Priority')],
            ["{$this->module_name}.status", "status", Lang::get('messages.Status')],
            ["assigned.name", "assigned_name", Lang::get('messages.Assigned')],
            ["updater.name", "user_name",Lang::get('messages.Updater')],
            ["{$this->module_name}.updated_at", "updated_at", Lang::get('messages.Updated-at')],
            ["{$this->module_name}.is_active", "is_active", Lang::get('messages.Active')]
        ];
    }

    /**
     * Construct SELECT statement based
     *
     * @return array
     */
    public function selectColumns()
    {
        $select_cols = [];
        foreach ($this->gridColumns() as $col)
            $select_cols[] = $col[0] . ' as ' . $col[1];

        return $select_cols;
    }

    /**
     * Define Query for generating results for grid
     *
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function sourceTables()
    {
        return DB::table($this->module_name)
            ->leftJoin('users as updater', $this->module_name . '.updated_by', 'updater.id')
            ->leftJoin('users as assigned',$this->module_name. '.assigned_to','assigned.id');
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
        if(in_array('5',user()->groupIds())){
            $query = $query->where('tasks.created_by' , user()->id)->orWhere('tasks.assigned_to',user()->id);

        }
        // Construct query based on filter param
        $query = self::filterQueryConstructor($query);
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
    public function datatableModify($dt)
    {
        // First set columns for  HTML rendering
        $dt = $dt->rawColumns(['id', 'name', 'is_active']); // HTML can be printed for raw columns

        // Next modify each column content
        $dt = $dt->editColumn('name', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$name}}</a>');
        $dt = $dt->editColumn('id', '<a href="{{ route(\'' . $this->module_name . '.edit\', $id) }}">{{$id}}</a>');
        $dt = $dt->editColumn('is_active', '@if($is_active)  Yes @else <span class="text-red">No</span> @endif');

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

    /**
     * Transform form inputs
     *
     * @param array $inputs
     * @return array
     */
    // public function transformInputs($inputs = [])
    // {
    //     return $inputs;
    // }
    // ****************** transformInputs functions end ***********************


    public function edit($id)
    {
        return parent::edit($id); // TODO: Change the autogenerated stub
    }

    /**
     * save updated paragraph sequence
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSaveSequence() {
        if (Request::has('seq') && is_array(Request::get('seq')) && count(Request::get('seq'))) {
            $i = 1;
            foreach (Request::get('seq') as $task_id) {
                $affectedRows = Task::where('id', $task_id)->update(
                    ['seq' => $i++]
                );
            }
        }
        if (Request::has('redirect_common')) {
            if (Request::get('redirect_common') == 'json') {
                $ret = [
                    'status' => 'success',
                    'message' => 'Sequence updated'
                ];
                return Response::json($ret);
            }
            return Redirect::to(Request::get('redirect_common'));
        }
        return Redirect::back();
    }
}
