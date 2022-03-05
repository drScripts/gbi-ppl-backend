<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Schedules;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index(Request $request)
    {
        Schedules::addCurrentPeople($request->id, 2);
        return ResponseFormatter::success([], 'success');
    }
}
