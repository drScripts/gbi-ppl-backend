<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $payload = $request->attributes->get("payload");

            $announcements = Announcement::where("cabang_id", $payload['cabang_id'])->latest()->paginate();

            return ResponseFormatter::success($announcements, "Success Get Data!");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), 500);
        }
    }

    public function banner(Request $request): JsonResponse
    {
        try {
            $payload = $request->attributes->get("payload");

            $announcements = Announcement::where("cabang_id", $payload['cabang_id'])->latest()->take(5)->select("image_path")->get();

            return ResponseFormatter::success($announcements, "Success Get Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function addAnnouncement(Request $request): JsonResponse
    {
        $rules = [
            'title' => 'required|string',
            'description' => 'required',
            'image' => 'required|image',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) return ResponseFormatter::error($validation->errors(), "Validation errors");

        try {
            $payload = $request->attributes->get("payload");
            $fileName = $request->file('image')->store('announcement');

            Announcement::create([
                'cabang_id' => $payload['cabang_id'],
                'title' => $request->title,
                'description' => $request->description,
                'image_path' => $fileName,
            ]);

            return ResponseFormatter::success([], 'Success Add Data');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }
}
