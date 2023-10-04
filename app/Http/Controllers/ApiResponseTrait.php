<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Response;

/**
 * APIのレスポンスで使う形式を定義するtrait
 * Trait ApiResponse
 * @package App\Http\Controllers
 * @author KensukeSugiura
 */
trait ApiResponseTrait
{
    /**
     * @param  mixed        $result  データ
     * @param  string       $message メッセージ
     * @param  int          $code    HTTPステータスコード
     * @param  bool|null    $success 成功 or 失敗
     * @return JsonResponse
     */
    public function sendResponse($result, $message = '', $code = 200, bool $success = null): JsonResponse
    {
        return Response::json(
            [
                'success' => is_null($success) ? (int) $code === 200 : $success,
                'body'    => $result,
                'message' => $message,
            ],
            $code
        );
    }

    /**
     * @param  string       $message
     * @param  int          $code
     * @return JsonResponse
     */
    public function sendError($message, $code = 404): JsonResponse
    {
        return Response::json(
            [
                'success' => false,
                'message' => $message,
            ],
            $code
        );
    }

    /**
     * @param  string                $message
     * @param  int                   $code
     * @throws HttpResponseException
     * @return void
     */
    public function throwErrorResponse($message, $code = 404): void
    {
        throw new HttpResponseException(Response::json(['success' => false, 'message' => $message], $code));
    }

    /**
     * @param  string       $message
     * @return JsonResponse
     */
    public function sendSuccess($message = ''): JsonResponse
    {
        return Response::json(
            [
                'success' => true,
                'message' => $message,
            ],
            200
        );
    }
}
