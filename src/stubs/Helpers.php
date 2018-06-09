<?php

const SUCCESS = 0;
const FAILED = 2;
/**
 * Default api response for ajax
 */
const API_RESPONSE= [
    'status' => FAILED,
    'message' => 'An Error Occurred!',
    'data' => []
];

/**
 * Returns a success api response
 * @param $data
 * @param string $msg
 * @param array $meta
 * @return \Illuminate\Http\JsonResponse
 */
function apiSuccess($data, $msg = "Success", $meta = [])
{
    $responder = API_RESPONSE;
    $responder['status'] = 0;
    $responder['message'] = $msg;
    $responder['data'] = $data;
    $responder['meta'] = $meta;

    return response()->json( $responder );
}

/**
 * Returns a failed api response
 * @param $data
 * @param string $msg
 * @param int $code
 * @return \Illuminate\Http\JsonResponse
 */
function apiFailure($data, $msg = "An Error Occurred",  $code = 2)
{
    $responder = API_RESPONSE;
    $responder['status'] =  $code;
    $responder['message'] = $msg;
    $responder['data'] = $data;

    return response()->json($responder);
}
