<?php

namespace App\Helpers;

use App\Models\PushNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class SendNotification
{
    private $url = "https://exp.host/--/api/v2/push/send";

    public function sendNotification(array $data)
    {
        $this->postFunction($data);
    }

    public function broadcastLocal(string $title, string $body, array $data = [])
    {

        $notifications = PushNotification::whereHas("user", function (Builder $query) {
            $adminInfo = userInfo();
            $query->where("cabang_id", $adminInfo['cabang_id']);
        })->select("token")->get();

        $tokens = [];

        foreach ($notifications as $notif) {
            $tokens[] = $notif['token'];
        }
        $tokens = array_unique($tokens);

        foreach ($tokens as $token) {
            $this->postFunction([
                'to' => $token,
                'title' => $title,
                'body' => $body,
                'data' => json_encode($data),
            ]);
        }
    }


    private function postFunction(array $data)
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HEADER, array('Content-Type: application/json', 'Accept: */*'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_exec($ch);
        if (curl_error($ch)) {
            Log::debug(curl_error($ch));
        }

        curl_close($ch);
    }
}
