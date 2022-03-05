<?php

namespace App\Helpers;

class TelegramBotHelpers
{


    public static function sendMessage(string $message)
    {
        $id = env("TELEGRAM_ID_REDIRECT");
        $url = "https://api.telegram.org/bot5073130963:AAFuinNJfmykIMEideDJln8Dy3XaNzf9x_E/sendMessage?chat_id=" . $id . "&text=" . $message;

        file_get_contents($url);
    }
}
