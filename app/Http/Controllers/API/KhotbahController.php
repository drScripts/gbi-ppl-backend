<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Khotbah;
use Exception;
use Illuminate\Http\Request;

class KhotbahController extends Controller
{
    public function index(Request $request)
    {
        try {
            $payload = $request->attributes->get('payload');
            $khotbah = Khotbah::where('cabang_id', $payload['cabang_id'])->paginate();
            return ResponseFormatter::success($khotbah, 'Success Get Data');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function banner(Request $request)
    {
        try {
            $payload = $request->attributes->get("payload");

            $khotbah = Khotbah::where("cabang_id", $payload['cabang_id'])->latest()->take(5)->select("image_path")->get();

            return ResponseFormatter::success($khotbah, "Success Get Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }
}
