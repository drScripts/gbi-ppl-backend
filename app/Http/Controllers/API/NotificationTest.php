<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Helpers\SendNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationTest extends Controller
{

    private $notificationHelpers;


    function __construct()
    {
        $this->notificationHelpers = new SendNotification();
    }

    public function test()
    {
        $this->notificationHelpers->broadcastLocal("Test", "HAII GUYS JUST TESTING", ['url' => 'schedule']);

        return ResponseFormatter::success([], 'OK');
    }
}
