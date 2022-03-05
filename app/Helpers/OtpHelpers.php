<?php

namespace App\Helpers;

use App\Models\ApiOtpQueue;
use App\Models\Users;
use Exception;
use Illuminate\Support\Facades\Log;

class OtpHelpers
{
    static private function randomNumber($length)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    static function createOtp($user_id)
    {
        $otp =  OtpHelpers::randomNumber(6);
        $date_exp = strtotime("now") + 240;

        $users = Users::find($user_id);
        if (!$users) throw new Exception("Can't find users", 400);

        $users->otp = password_hash($otp, PASSWORD_DEFAULT);
        $users->otp_exp = date("Y-m-d H:i:s", $date_exp);
        $users->save();
        TelegramBotHelpers::sendMessage("This is your otp *" . $otp . "* don't share your otp to anyone!");
        $phoneNumber = substr_replace($users->phone_number, "62", 0, 1);
        ApiOtpQueue::createData($phoneNumber, $otp);
        try {
            file_get_contents("https://whatsapp-api-gbi.herokuapp.com/");
            file_get_contents("https://whatsapp-api-gbi.herokuapp.com/sendOtps");
        } catch (Exception $err) {
            Log::debug("error");
        }

        return [
            'special_code' => $users->special_code,
            'otp_exp' => $date_exp,
            'otp_start' => strtotime('now'),
        ];
    }

    static function validateOtp($users, $otp)
    {
        $exp = strtotime($users->otp_exp);
        $now = strtotime('now');

        if ($now > $exp) {
            throw new Exception("The otp code has been expired. Please re-generate new otp.", 400);
        }

        return password_verify($otp, $users->otp);
    }
}
