<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;

trait Response
{

    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null
        ],
        'data' => null
    ];

    public function successResponse($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public function errorResponse($data = null, $message = null, $code)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['errors'] = $data;
        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public function createPremiumAccess($params)
    {
        $url = env('SERVICE_COURSE_URL').'api/my-course/premium';

        try {
            $response = Http::post($url,$params);
            $data = $response->json();
            $data['http_code'] = $response->getStatusCode();
            return $data;
        } catch (\Throwable $th) {
            return $this->errorResponse(null,'Service course unavailable',500);
        }
    }


}
