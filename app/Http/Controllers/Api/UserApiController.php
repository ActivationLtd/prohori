<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\MessagesController;
use Request;
use App\Task;
use App\User;
use Response;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\RecommendurlsController;
use Illuminate\Support\Arr;

class UserApiController extends ApiController
{
    /**
     * Resolve user based on logged_user. This is set in middleware CheckBearerToken.
     * @return \App\User
     */
    public function user() {
        // This is set during bearer token check in middleware : app/Http/Middleware/CheckBearerToken.php
        return Request::get('logged_user');
    }

    /**
     * Gets user app users profile and summary data.
     * @return string
     */
    public function getUserProfile() {
        $ret = ret('success', "User information", ['data' => $this->user()]);
        return Response::json(fillRet($ret));
    }

    /**
     * Update a recommendation url
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function usersPatch() {
        return app(UsersController::class)->update($this->user()->id);
    }

    /**
     * Make user uploads
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadsStore() {
        Request::merge([
            'module_id' => 4, // 4=users module
            'element_id' => $this->user()->id,
        ]);
        return app(UploadsController::class)->store();
    }

    /**
     * Delete avatar
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function uploadsDeleteAvatar() {
        $this->user()->update(['profile_pic_url' => null]);
        $this->user()->uploads()->where('type', 'Profile photo')->delete();
        $ret = ret('success', "Profile photo deleted");
        return Response::json(fillRet($ret));
    }

    /**
     * @return mixed
     */
    public function summary() {
        $task_assigned = Task::where('assigned_to', $this->user()->id)->whereIn('status', ['To do', 'In Progress'])->count();
        $task_completed = Task::where('assigned_to', $this->user()->id)->whereIn('status', ['Done', 'Closed'])->count();
        $task_inprogress = Task::where('assigned_to', $this->user()->id)->whereIn('status', ['In Progress'])->count();
        $task_due = Task::where('assigned_to', $this->user()->id)->whereNotIn('status', ['Done', 'Closed'])->where('due_date', '<', now())->count();
        $data = [
            'tasks' => [
                'assigned' => $task_assigned,
                'in_progress' => $task_completed,
                'complete' => $task_inprogress,
                'due' => $task_due,
            ]
        ];
        $ret = ret('success', "User Task List", ['data' => $data]);
        return Response::json($ret);
    }

    /**
     * Get a list of tasks
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasks() {
        $tasks = Task::with(['subtasks', 'uploads', 'assignments', 'assignee', 'flagger', 'verifier', 'resolver', 'closer', 'parenttask'])
            ->where('is_active', 1);
        //checking if user is a manager
        if ($this->user()->inGroupId('5')) {
            $tasks = $tasks->where('created_by', $this->user()->id)
                ->orWhere('assigned_to', $this->user()->id);
        }
        /**
         * Construct WHERE clauses based on URL/API inputs
         *******************************************************************/
        # Generic API return
        if (Request::has('updatedSince')) {
            $tasks = $tasks->where('updated_at', '>=', Request::get('updatedSince'));
        }
        if (Request::has('createdSince')) {
            $tasks = $tasks->where('created_at', '>=', Request::get('createdSince'));
        }
        if (Request::has('updatedAt')) {
            $tasks = $tasks->whereRaw("DATE(updated_at) = " . "'" . Request::get('updateddAt') . "'");
        }
        if (Request::has('createdAt')) {
            $tasks = $tasks->whereRaw("DATE(created_at) = " . "'" . Request::get('createdAt') . "'");
        }
        $q_fields = columns('tasks');
        foreach (Request::all() as $name => $val) {
            if (in_array($name, $q_fields)) {
                if (is_array($val) && count($val)) {
                    $temp = removeEmptyVals($val);
                    if (count($temp)) {
                        $tasks = $tasks->whereIn($name, $temp);
                    }
                } else {
                    if (strlen($val) && strpos($val, ',') !== false) {
                        $tasks = $tasks->whereIn($name, explode(',', $val));
                    } else {
                        if (strlen($val)) {
                            if ($val == 'null') {
                                $tasks = $tasks->whereNull($name, $val); // Before select2
                            } else if (is_int($val)) {
                                $tasks = $tasks->where($name, $val); // Before select2
                            } else {
                                $tasks = $tasks->where($name, 'LIKE', "%$val%"); // Before select2
                            }
                        }
                    }
                }
            }
        }
        # Get total count with out offset and limit.
        $total = $tasks->count();

        # Sort by and roder
        $sort_by = Request::has('sort_by') ? Request::get('sort_by') : 'created_at';
        $sort_order = Request::has('sort_order') ? Request::get('sort_order') : 'desc';
        $tasks = $tasks->orderBy($sort_by, $sort_order);

        # Skip
        $offset = Request::has('offset') ? Request::get('offset') : 0;
        $tasks = $tasks->skip($offset);

        # Limit
        $max_limit = 20;
        $limit = (Request::has('limit') && Request::get('limit') <= $max_limit) ? Request::get('limit') : $max_limit;
        # Limit override
        $limit = (Request::get('force_all_data') === 'true') ? $tasks->remember(cacheTime('none'))->count() : $limit;
        $tasks = $tasks->take($limit);

        /*********** Query construction ends ********************/

        $data = $tasks->remember(cacheTime('none'))->get();
        $ret = ret('success', "User Task List", compact('data', 'total', 'offset', 'limit'));
        return Response::json($ret);
    }

    /**
     * Get a list of tasks for Dashboard
     * @return \Illuminate\Http\JsonResponse
     */
    public function dashboardTasks() {
        $tasks = Task::with(['subtasks', 'uploads', 'assignments', 'assignee', 'flagger', 'verifier', 'resolver', 'closer', 'parenttask'])
            ->where('is_active', 1)->whereIn('status', ['To do', 'In progress', 'Verify']);
        //checking if user is a manager
        if ($this->user()->inGroupId('5')) {
            $tasks = $tasks->where('created_by', $this->user()->id)
                ->orWhere('assigned_to', $this->user()->id);
        }
        /**
         * Construct WHERE clauses based on URL/API inputs
         *******************************************************************/
        # Generic API return
        if (Request::has('updatedSince')) {
            $tasks = $tasks->where('updated_at', '>=', Request::get('updatedSince'));
        }
        if (Request::has('createdSince')) {
            $tasks = $tasks->where('created_at', '>=', Request::get('createdSince'));
        }
        if (Request::has('updatedAt')) {
            $tasks = $tasks->whereRaw("DATE(updated_at) = " . "'" . Request::get('updateddAt') . "'");
        }
        if (Request::has('createdAt')) {
            $tasks = $tasks->whereRaw("DATE(created_at) = " . "'" . Request::get('createdAt') . "'");
        }

        $q_fields = columns('tasks');
        foreach (Request::all() as $name => $val) {
            if (in_array($name, $q_fields)) {
                if (is_array($val) && count($val)) {
                    $temp = removeEmptyVals($val);
                    if (count($temp)) {
                        $tasks = $tasks->whereIn($name, $temp);
                    }
                } else {
                    if (strlen($val) && strpos($val, ',') !== false) {
                        $tasks = $tasks->whereIn($name, explode(',', $val));
                    } else {
                        if (strlen($val)) {
                            if ($val == 'null') {
                                $tasks = $tasks->whereNull($name, $val); // Before select2
                            } else if (is_int($val)) {
                                $tasks = $tasks->where($name, $val); // Before select2
                            } else {
                                $tasks = $tasks->where($name, 'LIKE', "%$val%"); // Before select2
                            }
                        }
                    }
                }
            }
        }
        # Get total count with out offset and limit.
        $total = $tasks->count();

        # Sort by and roder
        $sort_by = Request::has('sort_by') ? Request::get('sort_by') : 'created_at';
        $sort_order = Request::has('sort_order') ? Request::get('sort_order') : 'desc';
        $tasks = $tasks->orderBy($sort_by, $sort_order);

        # Skip
        $offset = Request::has('offset') ? Request::get('offset') : 0;
        $tasks = $tasks->skip($offset);

        # Limit
        $max_limit = 20;
        $limit = (Request::has('limit') && Request::get('limit') <= $max_limit) ? Request::get('limit') : $max_limit;
        # Limit override
        $limit = (Request::get('force_all_data') === 'true') ? $tasks->remember(cacheTime('none'))->count() : $limit;
        $tasks = $tasks->take($limit);

        /*********** Query construction ends ********************/

        $data = $tasks->remember(cacheTime('none'))->get();
        $ret = ret('success', "User Task List", compact('data', 'total', 'offset', 'limit'));
        return Response::json($ret);
    }

    /**
     * Create a task
     * @return mixed
     */
    public function tasksCreate() {
        Request::merge(['created_by' => $this->user()->id]);
        return app(TasksController::class)->store();
    }
    /**
     * Delete a task
     */
    public function tasksDelete($id) {

         $task=Task::where('id',$id)->delete();
         $ret = ret('success', "Task ".$id." has been deleted");
         return Response::json(fillRet($ret));


    }
    /**
     * Create a recommendation url
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function tasksUpdate($id) {
        Request::merge(['updated_by' => $this->user()->id]);
        return app(TasksController::class)->update($id);
    }

    /**
     * Upload a file under task
     * @param $id task id
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasksUpload($id) {

        Request::merge([
            'module_id' => 29, // 29=users module
            'element_id' => $id,
            'created_by' => $this->user()->id,
        ]);
        return app(UploadsController::class)->store();
    }

    /**
     * @param $id
     */
    public function getUploads($id) {
        Request::merge(['element_id' => $id, 'module_id' => 29, 'sort_order' => 'desc']);
        return app(UploadsController::class)->list();
    }

    /**
     * @param $id
     */
    public function getSubtasks($id) {
        Request::merge(['parent_id' => $id, 'sort_by' => 'created_at', 'sort_order' => 'desc']);
        return app(TasksController::class)->list();
    }

    /**
     * @param $id
     */
    public function getAssignments($id) {
        Request::merge(['element_id' => $id, 'module_id' => 29, 'sort_order' => 'desc']);
        return app(AssignmentsController::class)->list();
    }

    /**
     * @param $id
     */
    public function getMessages($id) {
        Request::merge(['element_id' => $id, 'module_id' => 29, 'sort_order' => 'desc']);
        return app(MessagesController::class)->list();
    }
}
