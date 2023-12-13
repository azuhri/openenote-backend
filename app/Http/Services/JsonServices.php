<?php

namespace App\Http\Services;


class JsonServices {
    
    public function responseError($errors)  {
        return \response()->json(["errors" => $errors], 500);
    }

    public function responseData($data) {
        return \response()->json([
            "data" => $data,
        ], 200);
    }

    public function responseDataWithMessage($data, $message) {
        $data = ["data" => $data];
        if($message) {
            $data["message"] = $message;
        }
        return \response()->json($data, 200);
    }
}