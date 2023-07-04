<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponseHelper
{
    public static function success($message = 'Berhasil mendapatkan data', $data = null, $code =
    ResponseAlias::HTTP_OK): array
    {
        $res = [
            'code' => $code,
            'status' => true,
            'message' => $message,
        ];

        if ($data) {
            $res['data'] = $data;
        }

        return $res;
    }

    public static function error($message = 'Network Error', $error = null, $code =
    ResponseAlias::HTTP_BAD_REQUEST): array
    {
        $res = [
            'code' => $code,
            'status' => false,
            'message' => $message,
        ];

        if ($error) {
            $res['errors'] = $error;
        }

        return $res;
    }

    public static function notFound($message = 'Data tidak di temukan', $code = ResponseAlias::HTTP_OK): array
    {
        return [
            'code' => $code,
            'status' => true,
            'message' => $message,
            'data' => []
        ];
    }

    public static function serverError($error = null, $message = 'Terjadi kesalahan pada server', $code =
    ResponseAlias::HTTP_INTERNAL_SERVER_ERROR): array
    {
        return [
            'code' => $code,
            'status' => false,
            'message' => $message,
            'error' => $error,
        ];
    }
}
