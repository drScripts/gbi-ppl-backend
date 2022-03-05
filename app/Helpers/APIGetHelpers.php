<?php

namespace App\Helpers;

class APIGetHelpers
{

    private string $urls;

    public function __construct(string $url)
    {
        $api_key = env("YOUTUBE_API_KEY");
        $this->urls = $url . "&key=" . $api_key;
    }

    public function get()
    {
        $response = file_get_contents($this->urls);
        $response = json_decode($response, true);
        return $this->prettier($response);
    }

    public static function prettier($response)
    {
        return [
            "nextPageToken" => $response["nextPageToken"] ?? null,
            "prevPageToken" => $response['prevPageToken'] ?? null,
            "pageInfo" => $response['pageInfo'],
            "items" => $response["items"]
        ];
    }
}
