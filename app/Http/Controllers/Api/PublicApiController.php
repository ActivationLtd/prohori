<?php

namespace App\Http\Controllers\Api;

use App\Apiresponse;
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
}
