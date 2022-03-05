<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class ApiOtpQueue extends Eloquent
{
    public static function createData($phone_number, $otp)
    {
        return DB::connection("mongodb")->collection('queues')->insert([
            'phone_number' => $phone_number,
            'otp' => $otp
        ]);
    }
}
