<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Положительный ответ сервера
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccessResponse($data = [], $message = ''){
        $response = [
            'status'  => 'Ok',
            'message' => $message,
            'data'    => $data
        ];

        return response()->json($response, 200);
    }

    /**
     * Ответ сервера содержащий вывод ошибок
     * @param array $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendErrorResponse($message = []){
        return response()->json([
            'status'  => 'Error',
            'message' => $message
        ], 200);
    }
}
