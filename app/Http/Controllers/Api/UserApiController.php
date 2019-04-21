<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AssignmentsController;
use Request;
use App\Task;
use App\User;
use Response;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UploadsController;
use App\Http\Controllers\RecommendurlsController;

class UserApiController extends ApiController
{
    /**
     * Resolve user based on logged_user. This is set in middleware CheckBearerToken.
     * @return \App\User
     */
    public function user()
    {
        // This is set during bearer token check in middleware : app/Http/Middleware/CheckBearerToken.php
        return Request::get('logged_user');
    }

    /**
     * Gets user app users profile and summary data.
     * @return string
     */
    public function getUserProfile()
    {
        $ret = ret('success', "User information", ['data' => $this->user()]);
        return Response::json(fillRet($ret));
    }

    /**
     * Update a recommendation url
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function usersPatch()
    {
        return app(UsersController::class)->update($this->user()->id);
    }

    /**
     * Make user uploads
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadsStore()
    {
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
    public function uploadsDeleteAvatar()
    {
        $this->user()->update(['profile_pic_url' => null]);
        $this->user()->uploads()->where('type', 'Profile photo')->delete();
        $ret = ret('success', "Profile photo deleted");
        return Response::json(fillRet($ret));
    }

    /**
     * @return mixed
     */
    public function summary()
    {
        $task_assigned=Task::where('assigned_to',$this->user()->id)->whereIn('status',['To do','In Progress'])->count();
        $task_completed=Task::where('assigned_to',$this->user()->id)->whereIn('status',['Done','Closed'])->count();
        $task_inprogress=Task::where('assigned_to',$this->user()->id)->whereIn('status',['In Progress'])->count();
        $task_due=Task::where('assigned_to',$this->user()->id)->whereNotIn('status',['Done','Closed'])->where('due_date','<',now())->count();
        $data = [
            'tasks' => [
                'assigned' => $task_assigned,
                'in_progress' => $task_completed,
                'complete' => $task_inprogress,
                'due' => $task_due,
            ]
        ];
        $ret  = ret('success', "User Task List", ['data' => $data]);
        return Response::json($ret);
    }

    /**
     * Get a list of tasks
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasks()
    {
        $tasks = Task::with(['subtasks', 'uploads', 'assignments','assignee','flagger','verifier','resolver','closer',])
            ->where('created_by', $this->user()->id)
            ->orWhere('assigned_to', $this->user()->id)
            ->where('is_active', 1)
            //->whereIn('status', ['to do','In progress','Verify'])
            ->get();
        foreach($tasks as $task){
            if(isset($task->watchers)){
                $emails=[];
                foreach($task->watchers as $user_id)
                {
                    $emails[]=User::find($user_id)->email;
                }
                $task->setAttribute('watcher_emails', $emails);
            }

        }

        $ret   = ret('success', "User Task List", ['data' => $tasks]);
        return Response::json($ret);
    }

    /**
     * Create a task
     * @return mixed
     */
    public function tasksCreate()
    {
        Request::merge(['created_by' => $this->user()->id]);
        return app(TasksController::class)->store();
    }

    /**
     * Create a recommendation url
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function tasksUpdate($id)
    {
        Request::merge(['updated_by' => $this->user()->id]);
        return app(TasksController::class)->update($id);
    }

    /**
     * Upload a file under task
     * @param $id task id
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasksUpload($id)
    {

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
    public function getUploads($id){
        Request::merge(['element_id' => $id, 'module_id' =>29, 'sort_order' => 'desc']);
        return app(UploadsController::class)->list();
    }
    /**
     * @param $id
     */
    public function getSubtasks($id){
        Request::merge(['parent_id' => $id, 'sort_by' => 'created_at', 'sort_order' => 'desc']);
        return app(TasksController::class)->list();
    }
    /**
     * @param $id
     */
    public function getAssignments($id){
        Request::merge(['element_id' => $id, 'module_id' =>29, 'sort_order' => 'desc']);
        return app(AssignmentsController::class)->list();
    }
}
