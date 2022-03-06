<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;

class UserNotification extends Controller
{
    public function getAllToken(Request $request)
    {
        try {
            $user = Users::with("notification")->get();

            return ResponseFormatter::success($user, "Success Get Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([
                "message" => $err->getMessage(),
                "code" => $err->getCode(),
            ], "Error", 500);
        }
    }
}
