<?php

namespace App\Traits;

use App\Utils\ResponseHelper;
use Illuminate\Http\JsonResponse;

trait ApiHelpersTrait
{
    public function success($message = null ,$data = null) : JsonResponse {

        return response()->json(
            [
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ],
        200);
    }
    public function sendError($error, $errorMessages = [], $code = ResponseHelper::HTTP_FORBIDDEN)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
