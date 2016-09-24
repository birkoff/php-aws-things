<?php

class Response
{
    public static function sendSuccess($response)
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($response);
    }

    public static function withError($message, $code = 500)
    {
        header('Content-Type: application/json');
        switch ($code) {
            case 404:
                http_response_code(404);
                break;
            case 400:
                http_response_code(400);
                break;
            case 500:
            default:
                http_response_code(500);
                break;
        }
        $error = array('error' => $message, 'status' => $code);
        echo json_encode($error);
        exit;
    }
}
