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

        //TODO: create a custom log level and include ErrorCode and Request into the log
        if (ErrorCode::is_set($code)) {
            Log::log("info", $responseData["message"]);
        }

        // Handle data
        if ($data != null) {
            // $data['errorModalHeader']= 'ERROR!';
            // $data['errorModalBody']= "This data not found";
            // $responseData["data"] = $data;

            // return Inertia::render(
            //     component: 'Frontend/Create',
            //     props: $data
            // );
        } else {
            // return Inertia::render(
            //     component: 'Frontend/Create',
            //     props: [
            //         'errorModalHeader' => 'ERROR!',
            //         'errorModalBody' => $responseData,
            //         'code' => constant("App\\Exceptions\\ResponseStatus::$code"),
            //         $data
            //     ]
            // );
        }
    }
}
