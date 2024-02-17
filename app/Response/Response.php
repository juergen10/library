<?php

namespace App\Response;

use Carbon\Carbon;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Formatters\ErrorMessageFormatter;

class Response
{
    public static function send(int $code, $data = null, string $message = null, array $headers = [])
    {
        $response = [];

        if (null !== $data) {
            $response['data'] = $data;
        }

        if ($data instanceof MessageBag) {
            $response['data'] = ErrorMessageFormatter::format($data);
        }

        if (null !== $message) {
            $response['message'] = $message;
        }

        $result = (new JsonResponse($response, $code, $headers))->setEncodingOptions(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $result;
    }

    public static function message(string $message)
    {
        return static::send(400, null, $message);
    }
}
