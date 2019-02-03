<?php

namespace App\Http\Controllers;

use App\Module;
use App\Reportbuilder;
use App\Traits\IsoGridDatatable;
use App\Traits\IsoOutput;
use App\Upload;
use DB;
use Redirect;
use Request;
use Response;
use Validator;
use View;

/**
 * Class ModulebaseController
 */
class ModulebaseController extends Controller
{
    use IsoOutput;
    use IsoGridDatatable;

    protected $module_name;         // Stores module name with lowercase and plural i.e. 'superheros'.
    protected $module;         // Stores module name with lowercase and plural i.e. 'superheros'.
    protected $query;          // Stores default DB query to create the grid. Used in grid() function.
    protected $grid_columns;        // Columns to show, this array is set form modules individual controller.
    protected $report_data_source = null;  // loads the model name

    /**
     * Constructor for this class is very important as it boots up necessary features of
     * Spyr module. First of all, it load module related meta information, then based
     * on context check(tenant context) it loads the tenant id. The it constructs the default
     * grid query and also add tenant context to grid query if applicable. Finally it
     * globally shares a couple of variables $module_name, $mod to all views rendered
     * from this controller
     *
     */
    public function __construct()
    {

        $this->module_name = controllerModule(get_class($this));
        $this->module = Module::where('name', $this->module_name)->remember(cacheTime('long'))->first();


        # Add tenant context Inject tenant context in grid query
        if ($tenant_id = inTenantContext($this->module_name)) {
            Request::merge([tenantIdField() => $tenant_id]); // Set tenant_id in request header
        }

        // Share the variables across all views accessed by this controller
        View::share([
            'module_name' => $this->module_name,
            'mod' => $this->module
        ]);
    }

    /**
     * Index/List page to show grid
     * This controller method is responsible for rendering the view that has the default
     * spyr module grid.
     *
     * @return \App\Http\Controllers\ModulebaseController|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (hasModulePermission($this->module_name, 'view-list')) {
            if (Request::get('ret') == 'json') {
                return self::list();
            }
            $view = 'modules.base.grid';
            if (View::exists('modules.' . $this->module_name . '.grid')) {
                $view = 'modules.' . $this->module_name . '.grid';
            }
            return view($view)->with('grid_columns', $this->gridColumns());
        } else {
            return View::make('template.blank')
                ->with('title', 'Permission denied!')
                ->with('body', "You don't have permission [ " . $this->module_name . ".view-list]");
        }
    }

    /**
     * Shows an element create form.
     *
     * @return \Illuminate\Contracts\View\View|\View
     */
    public function create()
    {
        if (hasModulePermission($this->module_name, 'create')) { // check for create permission
            $uuid = (Request::old('uuid')) ? Request::old('uuid') : uuid(); // Set uuid for the new element to be created
            return View::make('modules.base.form')->with('uuid', $uuid)->with('element_editable', true);
        } else {
            return View::make('template.blank')
                ->with('title', 'Permission denied!')
                ->with('body', "You don't have permission [ " . $this->module_name . ".create]");
        }
    }

    /**
     * Store an spyr element. Returns json response if ret=json is sent as url parameter. Otherwise redirects
     * based on the url set in redirect_success|redirect_fail
     *
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
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
        $element = new $Model(Request::all());
        if (hasModulePermission($this->module_name, 'create')) { // check module permission
            $validator = Validator::make(Request::all(), $Model::rules($element), $Model::$custom_validation_messages);

            // $element = new $Model;
            // $element->fill(Request::all());
            // $validator = $element->validateModel();

            if ($validator->fails()) {
                $ret = ret('fail', "Validation error(s) on creating {$this->module->title}.", ['validation_errors' => json_decode($validator->messages(), true)]);
            } else {
                if ($element->isCreatable()) {
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
        // if (Request::get('ret') == 'json') {
        //     // fill with session values(messages, errors, success etc) and redirect
        //     $ret = fillRet($ret);
        //     if ($ret['status'] == 'success' && (isset($ret['redirect']) && $ret['redirect'] == '#new')) {
        //         $ret['redirect'] = route("$module_name.edit", $element->id);
        //     }
        //     return Response::json($ret);
        // } else {
        //     if ($ret['status'] == 'fail') {
        //         // Obtain redirection path based on url param redirect_fail
        //         // Or, default redirect to back if no param is set.
        //         $redirect = Request::has('redirect_fail') ? Redirect::to(Request::get('redirect_fail')) : Redirect::back();
        //
        //         // Include Inputs and Validation errors in redirection.
        //         $redirect = $redirect->withInput();
        //         if (isset($validator)) $redirect = $redirect->withErrors($validator);
        //
        //     } else {
        //         // Obtain redirection path based on url param redirect_fail
        //         // Or, default redirect to back if no param is set.
        //         if (Request::has('redirect_success')) {
        //             $redirect = Request::get('redirect_success') == '#new' ? Redirect::route("$module_name.edit", $element->id)
        //                 : Redirect::to(Request::get('redirect_success'));
        //         } else {
        //             $redirect = Redirect::back();
        //         }
        //     }
        //
        //     return $redirect;
    }

    /**
     * Shows an spyr element. Store an spyr element. Returns json response if ret=json is sent as url parameter.
     * Otherwise redirects to edit page where details is visible as filled up edit form.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        $module_name = $this->module_name;
        $Model = model($this->module_name);
        //$element_name = str_singular($module_name);
        //$ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process show
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if the element exists
            if ($element->isViewable()) { // Check if the element is viewable
                //$ret = ret('success', "$Model " . $element->id . " found", ['data' => $element]);
                $ret = ret('success', "", ['data' => $element]);
            } else { // not viewable
                $ret = ret('fail', "{$this->module->title} is not viewable.");
            }
        } else { // The element was not found or has been deleted.
            $ret = ret('fail', "{$this->module->title} could not be found. The element is either unavailable or deleted.");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') === 'json') {
            return Response::json(fillRet($ret));
        } else {
            if ($ret['status'] === 'fail') { // Show failed. Redirect to fail path(url)
                return Redirect::route('home');
            } else { // Redirect to edit path
                return Redirect::route("$module_name.edit", $id);
            }
        }
    }

    /**
     * Show spyr element edit form
     *
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        $module_name = $this->module_name;
        $Model = model($this->module_name);
        $element_name = str_singular($module_name);
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if the element you are trying to edit exists
            if ($element->isViewable()) { // Check if the element is viewable
                return View::make('modules.base.form')
                    ->with('element', $element_name)//loads the singular module name in variable called $element = 'user'
                    ->with($element_name, $element)//loads the object into a variable with module name $user = (user object)
                    ->with('element_editable', $element->isEditable());
            } else { // Not viewable by the user. Set error message and return value.
                //return showPermissionErrorPage("The element is not view-able by current user.");
                return View::make('template.blank')
                    ->with('title', 'Permission denied!')
                    ->with('body', "The element is not view-able by current user. [ Error :: isViewable()]");
            }
        } else { // The element does not exist. Set error and return values
            //return showGenericErrorPage("The item that you are trying to access does not exist or has been deleted");
            return View::make('template.blank')
                ->with('title', 'Not found!')
                ->with('body', "The item that you are trying to access does not exist or has been deleted");
        }
    }

    /**
     * Update handler for spyr element.
     *
     * @param $id
     * @var \App\Basemodule $Model
     * @var \App\Basemodule $element
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {

        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        $Model = model($this->module_name);
        $ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process update
        # --------------------------------------------------------
        $validator = null;
        if ($element = $Model::find($id)) { // Check if element exists.
            if ($element->isEditable()) { // Check if the element is editable.
                $element->fill(Request::all());

                $validator = $element->validateModel();
                if ($validator->fails()) {
                    $ret = ret('fail', "Validation error(s) on updating {$this->module->title}.", ['validation_errors' => json_decode($validator->messages(), true)]);
                } else {
                    if ($element->fill(Request::all())->save()) { // Attempt to update/save.
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
        // if (Request::get('ret') == 'json') {
        //     return Response::json(fillRet($ret));
        // } else {
        //     if ($ret['status'] == 'fail') { // Update failed. Redirect to fail path(url)
        //         // Obtain redirection path based on url param redirect_fail
        //         // Or, default redirect to back if no param is set.
        //         $redirect = Request::has('redirect_fail') ? Redirect::to(Request::get('redirect_fail')) : Redirect::back();
        //         // Include Inputs and Validation errors in redirection.
        //         $redirect = $redirect->withInput();
        //         if (isset($validator)) $redirect = $redirect->withErrors($validator);
        //     } else {
        //         // Obtain redirection path based on url param redirect_fail
        //         // Or, default redirect to back if no param is set.
        //         $redirect = Request::has('redirect_success') ? Redirect::to(Request::get('redirect_success')) : Redirect::back();
        //     }
        //     return $redirect;
        // }
    }

    /**
     * Delete spyr element.
     *
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables
        // $module_name = $this->module_name;
        $Model = model($this->module_name);
        // $element_name = str_singular($module_name);
        // $ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process delete
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // check if the element exists
            if ($element->isDeletable()) { // check if the element is editable
                if ($element->delete()) { // attempt delete and set success message return values
                    $ret = ret('success', "{$this->module->title} has been deleted");
                } else { // handle delete failure and set error message and return values
                    $ret = ret('fail', "{$this->module->title} delete failed.");
                }
            } else { // element is not editable(which also means not deletable)
                $ret = ret('fail', "{$this->module->title} could not be deleted.");
            }
        } else { // the element was not fonud. Set error message and return value
            $ret = ret('fail', "{$this->module->title} could not be found. The element is either unavailable or deleted.");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') === 'json') {
            return Response::json($ret = fillRet($ret));
        } else {
            if ($ret['status'] === 'fail') { // Delete failed. Redirect to fail path(url)
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                $redirect = Request::has('redirect_fail') ? Redirect::to(Request::get('redirect_fail')) : Redirect::back();
            } else { // Delete successful. Redirect to success path(url)
                // Obtain redirection path based on url param redirect_fail
                // Or, default redirect to back if no param is set.
                if (Request::has('redirect_success')) $redirect = Redirect::to(Request::get('redirect_success'));
                else {
                    return View::make('template.blank')
                        ->with('title', 'Delete success!')
                        ->with('body', "The item that you are trying to access does not exist or has been deleted");
                }
            }
            return $redirect;
        }
    }

    /**
     * Restore a soft-deleted.
     *
     * @param null $id
     * @return $this
     */
    public function restore($id = null)
    {
        //return showGenericErrorPage("[$id] can not be restored. Restore feature is disabled");
        return View::make('template.blank')
            ->with('title', 'Restore not allowed')
            ->with('body', "The item can not be restored");
    }

    /**
     * Returns a collection of objects as Json
     *
     * @var \App\Basemodule $Model
     * @var \Illuminate\Database\Eloquent\Builder $q
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        /** @var \App\Basemodule $Model */
        /** @var \Illuminate\Database\Eloquent\Builder $q */
        $Model = model($this->module_name);

        if (Request::has('columns')) {
            $q = $Model::select(explode(',', Request::get('columns')));
        } else {
            $q = new $Model;
        }

        // Eager load
        if (Request::has('with')) {
            $with = Request::get('with');
            $q = $q->with(explode(',', $with));
        }
        // Force is_active = 1
        $q->where('is_active', 1);

        // Construct query based on filter param
        $q = self::filterQueryConstructor($q);

        // Get total count with out offset and limit.
        $total = $q->count();

        // Sort
        $sort_by = 'created_at';
        if (Request::has('sort_by')) {
            $sort_by = Request::get('sort_by');

        }
        $sort_order = 'desc';
        if (Request::has('sort_order')) {
            $sort_order = Request::get('sort_order');
        }
        $q = $q->orderBy($sort_by, $sort_order);

        // set offset
        $offset = 0;
        if (Request::has('offset')) {
            $offset = Request::get('offset');
            $q = $q->skip($offset);
        }

        //set limit
        $limit = $max_limit = 20;
        if (Request::has('limit')) {
            if (Request::get('limit') <= $max_limit) {
                $limit = Request::get('limit');
            }
        }
        // Limit override - Force all data with no limit.
        if (Request::get('force_all_data') === 'true') {
            $limit = $q->remember(cacheTime('none'))->count();
        }
        $q = $q->take($limit);

        /*********** Query construction ends ********************/

        $data = $q->remember(cacheTime('none'))->get();
        $ret = ret('success', "{$this->module_name} list", compact('data', 'total', 'offset', 'limit'));
        return Response::json(fillRet($ret));
    }

    /**
     * Json return query constructor
     *
     * @param $q \Illuminate\Database\Query\Builder
     * @return \App\Basemodule
     */
    public function filterQueryConstructor($q)
    {
        $Model = model($this->module_name);
        //$module_sys_name = $this->module_name;

        /** @var \App\Basemodule $q */
        /** @var \App\Basemodule $Model */
        // $q = $q->where('is_active', 1);

        if (inTenantContext($this->module_name)) {
            $q = injectTenantIdInModelQuery($this->module_name, $q);
        }

        # Generic API return
        if (Request::has('updatedSince')) $q = $q->where('updated_at', '>=', Request::get('updatedSince'));
        if (Request::has('createdSince')) $q = $q->where('created_at', '>=', Request::get('createdSince'));
        if (Request::has('updatedAt')) $q = $q->whereRaw("DATE(updated_at) = " . "'" . Request::get('updateddAt') . "'");
        if (Request::has('createdAt')) $q = $q->whereRaw("DATE(created_at) = " . "'" . Request::get('createdAt') . "'");

        if (Request::has('fieldName') && Request::has('fieldValue')) {
            $fieldName = Request::get('fieldName');
            $fieldValue = Request::get('fieldValue');
            $q = $q->where($fieldName, $fieldValue);
        }

        $q_fields = columns($this->module_name);
        foreach (Request::all() as $name => $val) {
            if (in_array($name, $q_fields)) {
                if (is_array($val) && count($val)) {
                    $temp = removeEmptyVals($val);
                    if (count($temp)) $q = $q->whereIn($name, $temp);
                } else if (strlen($val) && strstr($val, ',')) {
                    $q = $q->whereIn($name, explode(',', $val));
                } else if (strlen($val)) {
                    // $q = $q->where($name, $val); // Before select2
                    $q = $q->where($name, 'LIKE', "%$val%"); // For select2
                }
            }
        }
        #sort field
        // if (Request::has('sort_by')) {
        //     $sort_by = Request::get('sort_by');
        //     $q = $q->orderBy($sort_by, 'ASC');
        // }
        # set offset
        /*if (Request::has('offset')) $q = $q->skip(Request::get('offset'));
        #set limit
        $limit = $max_limit = 20;
        if (Request::has('limit')) {
            if (Request::get('limit') <= $max_limit) {
                $limit = Request::get('limit');
            }
        }
        $q = $q->take($limit);*/

        return $q;

    }

    /*public function filterQueryConstructorAddLimit($q) {
        # set offset
        if (Request::has('offset')) $q = $q->skip(Request::get('offset'));
        #set limit
        $limit = $max_limit = 20;
        if (Request::has('limit')) {
            if (Request::get('limit') <= $max_limit) {
                $limit = Request::get('limit');
            }
        }
        $q = $q->take($limit);

        return $q;
    }*/

    /**
     * Show all the changes/change logs of an item
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|ModulebaseController
     */
    public function changes($id)
    {
        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        // init local variables

        /** @var \App\Basemodule $Model */
        /** @var \App\Basemodule $element */
        $Model = model($this->module_name);
        //$ret = ret(); // load default return values
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if ($element = $Model::find($id)) { // Check if the element you are trying to edit exists
            if ($element->isViewable()) { // Check if the element is viewable
                $changes = $element->changes;
                $ret = ret('success', "", ['data' => $changes]);
            } else { // Not viewable by the user. Set error message and return value.
                $ret = ret('fail', "The element is not view-able by current user.");
                //return showPermissionErrorPage("The element is not view-able by current user.");
            }
        } else { // The element does not exist. Set error and return values
            $ret = ret('fail', "The item that you are trying to access does not exist or has been deleted");
            //return showGenericErrorPage("The item that you are trying to access does not exist or has been deleted");
        }
        # --------------------------------------------------------
        # Process return/redirect
        # --------------------------------------------------------
        if (Request::get('ret') == 'json') {
            return Response::json(fillRet($ret));
        } else {
            if ($ret['status'] == 'fail') { // Update failed. Redirect to fail path(url)
                return showGenericErrorPage($ret['message']);
            } else { // Update successful. Redirect to success path(url)
                /** @var array $changes */
                return View::make('modules.base.changes')
                    ->with('changes', $changes);
            }
        }
    }

    /**
     * Module generic report
     *
     * @return \App\Http\Controllers\JsonResponse|bool|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function report()
    {

        if (hasModulePermission($this->module_name, 'report')) {
            # Report source table/view
            if (!$this->report_data_source) { // If no source(view/table) is set in Module controller set the default table.
                $this->report_data_source = DB::getTablePrefix() . $this->module_name;
            }

            /** @var string $data_source SQL view/table full name */
            $data_source = $this->report_data_source; // Define data source

            /***************************************************/

            /** @var  $result_path  Define path to results view */
            $result_path = "modules.base.report.results"; // Define result path
            // Override default if a module specific report blade exists in location  "{module_name}.report.result"
            $module_report_view_path = $this->module_name . ".report.results";
            if (View::exists($module_report_view_path)) $result_path = $module_report_view_path;

            // Again override if a tenant specific result blade exists in "{module_name}.{tenant_id.}report.result"
            if (userTenantId()) {
                $tenant_report_view_path = $this->module_name . "." . userTenantId() . ".report.results";
                if (View::exists($tenant_report_view_path)) $result_path = $tenant_report_view_path;
            }
            /***************************************************/

            if (Request::has('submit') && Request::get('submit') == 'Run') {

                /** @var string $fields_csv_esc Select fields enclosed in escape character (`) */
                $fields_csv_esc = Reportbuilder::fieldsEscCsvPG(Reportbuilder::fieldsPG($data_source));

                /** @var array $data_source_fields Fields of data source (SQL table, view) */
                $data_source_fields = Reportbuilder::dataSourceFields($data_source);

                /***********************************************
                 * Customize : Over-ride this custom query builder for
                 * handling special fields. i.e. date range etc.
                 ***********************************************/
                /** @var string $filters SQL where clause */
                $filters = Reportbuilder::sqlFiltersFromInputsPG($data_source_fields, $data_source);

                /***************************************************************************/
                // Based on currently logged in user type further narrow down the query
                // by adding tenant context or facility context.
                /***************************************************************************/
                if ($user = user()) {
                    if (userTenantId() && in_array(tenantIdField(), $data_source_fields)) {
                        $filters .= " AND \"public\"." . $data_source . '.' . tenantIdField() . "='" . userTenantId() . "' ";
                    }
                }
                /***********************************************/

                /** @var string $group_by Group By string */
                $group_by = Reportbuilder::groupByPG($data_source);

                /***********************************************
                 * Customize : Over-ride this for cases where more fields are required to show. i.e. male, female count in
                 * sanctioned post report.
                 ***********************************************/
                // Add count field (Total) to select fields.
                if (strlen(trim($group_by))) $fields_csv_esc .= ",Count(*) AS \"total\" ";

                /***************************************************************************/
                // Result
                /***************************************************************************/
                /** @var array $ret compact('results', 'sql', 'total', 'pagination') */
                $ret = Reportbuilder::query($data_source, $fields_csv_esc, $filters, $group_by);

                /***************************************************************************/
                // Output
                /***************************************************************************/

                return Reportbuilder::render($ret, $result_path);

            } else {
                return view($result_path);
            }
        } else {
            return view('template.blank')->with('title', 'Permission denied!')
                ->with('body', "You don't have permission [ " . $this->module_name . ".report]");
        }
    }
}
