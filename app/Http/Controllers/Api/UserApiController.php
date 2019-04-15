<?php

namespace App\Http\Controllers\Api;

use Request;
use App\Task;
use Response;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UploadsController;

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
     * Make user uplaods
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
        $this->user()->update(['avatar_url' => null]);
        $this->user()->uploads()->where('type', 'Avatar')->delete();
        $ret = ret('success', "Avatar deleted");
        return Response::json(fillRet($ret));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function tasks()
    {
        $tasks = Task::with(['subtasks', 'uploads', 'assignments'])
            ->where('created_by', $this->user()->id)
            ->orWhere('assigned_to', $this->user()->id)->where('is_active', 1)->get();
        $ret   = ret('success', "User Task List", ['data' => $tasks]);
        return Response::json($ret);
    }

    /**
     * @return mixed
     */
    public function summary()
    {
        $data = [
            'tasks' => [
                'assigned' => 99,
                'in_progress' => 99,
                'complete' => 99,
                'due' => 99,
            ]
        ];
        $ret  = ret('success', "User Task List", ['data' => $data]);
        return Response::json($ret);
    }
}
