<?php

namespace App\Helpers;

class YoutubeHelpers
{
    public static function getData(string $categories)
    {
        $url = "https://youtube.googleapis.com/youtube/v3/search?part=snippet&channelId=UCyj9f0TiLAlOHcogOErkIbw&eventType=" . $categories . "&maxResults=10&order=date&type=video";
        $api = new APIGetHelpers($url);

        $items = $api->get();

        $fixedData = [];

        foreach ($items['items'] as $item) {
            array_push($fixedData, [
                'title' => $item['snippet']['title'],
                'description' => $item['snippet']['description'],
                'thumbnail' => $item['snippet']['thumbnails']['high']['url'],
                'publishedAt' => date("Y-m-d", strtotime($item['snippet']['publishedAt'])),
                'category' => $categories,
            ]);
        }

        return $fixedData;
    }
}
