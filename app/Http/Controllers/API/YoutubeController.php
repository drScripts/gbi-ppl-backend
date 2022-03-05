<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Helpers\YoutubeHelpers;
use App\Http\Controllers\Controller;
use App\Models\YoutubeModel;
use Exception;

class YoutubeController extends Controller
{

    public function index(Request $request)
    {
        try {
            $data = YoutubeModel::where("category", 'completed')->get();
            return ResponseFormatter::success($data, "Success Get Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), 600);
        }
    }

    public function upcoming(Request $request)
    {
        try {
            $data = YoutubeModel::where("category", 'upcoming')->get();
            return ResponseFormatter::success($data, "Success Get Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), 600);
        }
    }

    public function reset(Request $request)
    {
        try {
            $upcoming = YoutubeHelpers::getData('upcoming');
            $completed = YoutubeHelpers::getData('completed');
            YoutubeModel::truncate();

            if ($upcoming) {
                foreach ($upcoming as $item) {
                    YoutubeModel::create($item);
                }
            }

            if ($completed) {
                foreach ($completed as $item) {
                    YoutubeModel::create($item);
                }
            }


            return ResponseFormatter::success([], "Selesai");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), 500);
        }
    }
}
