<?php

namespace App\Http\Controllers\Api;

use App\Apiresponse;
use App\Beacon;
use App\User;
use Illuminate\Http\Request;
use Response;

class PublicApiController extends ApiController
{

    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization, X-CSRF-Token','X-Auth-Token");
    }

    /**
     * Catch API requests from external sources. This is to log in telescope.
     *
     * @return string
     */
    public function catch()
    {
        return Response::json(fillRet(ret('success')));
    }

    /**
     * Gets beacon(Purchase Json) from external partner site and stores.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function beaconsStore(Request $request)
    {
        $headers = json_encode($request->header()); // From array to json
        $data = json_encode($request->all());
        if ($beacon = Beacon::create(['data' => $data, 'headers' => $headers])) {
            $ret = ret('success', 'Purchase success', ['data' => $beacon]);
        } else {
            $ret = ret('fail', 'Purchase was not successful');
        }
        return Response::json(fillRet($ret));
    }

    /**
     * Adds API response
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiresponsesStore(Request $request)
    {
        $headers = json_encode($request->header()); // From array to json
        $data = json_encode($request->all());
        if ($apiresponse = Apiresponse::create(['event' => $request->get('event'), 'response' => $data, 'header' => $headers])) {
            $ret = ret('success', 'Payload stored', ['data' => $apiresponse]);
        } else {
            $ret = ret('fail', 'Purchase was not successful');
        }
        return Response::json(fillRet($ret));
    }

    /**
     * Get user names from share_code
     *
     * @param $share_code
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserNameFromShareCode($share_code, Request $request)
    {

        if ($user = User::where('share_code', $share_code)->first()) {
            $ret = ret('success', 'User found', ['data' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'name' => $user->name,
            ]]);
        } else {
            $ret = ret('fail', 'Invalid share_code');
        }

        return Response::json(fillRet($ret));
    }
}
