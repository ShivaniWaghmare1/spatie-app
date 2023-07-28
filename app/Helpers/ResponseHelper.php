<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Inertia\Inertia;
use App\Exceptions\ErrorCode;
use Illuminate\Support\Facades\Log;

class ResponseHelper
{
    public static function respond($code, $data = null)
    {
        $responseData = [
            "success" => true,
        ];

        //Check weather it is an error or success
        if (ErrorCode::is_set($code)) {
            $responseData["success"] = false;
            $responseData["error_code"] = constant("App\\Exceptions\\ErrorCode::$code");
        }

        // Handle error message
        $responseData["message"] = constant("App\\Exceptions\\ResponseMessage::$code");

        // Handle data
        if ($data != null) {
            $responseData["data"] = $data;
        }
        //Preparing final response
        $response = response()->json($responseData);

        //TODO: create a custom log level and include ErrorCode and Request into the log
        // if (ErrorCode::is_set($code)) {
        //     //request()->all();
        //     Log::log("info", $responseData["message"]);
        // }

        return $response;
    }
}
