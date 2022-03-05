<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Helpers\TelegramBotHelpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class BotApiController extends Controller
{
    public function index(Request $request, $id = null)
    {
        try {
            $message = $request->message['text'];
            if (str_contains($message, "getOtp")) {
                TelegramBotHelpers::sendMessage("No Otp Other wise");
            }

            return ResponseFormatter::success([], 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), 500);
        }
    }
}
