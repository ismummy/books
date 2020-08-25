<?php


namespace App\Helpers;


class ApiResponse
{
    public function processResponse($data, $message = 'Successful', $error = false, $code = 200)
    {
        $result = [];

        $result['error'] = $error;
        $result['code'] = $code;
        $result['message'] = $message;
        $result['data'] = $data;

        return $result;
    }
}
