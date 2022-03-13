<?php

namespace App\Http\Controllers;

use App\Models\Attendances;
use App\Models\Regions;
use App\Models\Schedules;
use App\Models\Users;

class DashboardController extends Controller
{
    public function index()
    {

        $grafik = Attendances::whereYear('created_at', date('Y'))->whereHas("schedule", function ($q) {
            $user = userInfo();
            $q->where("cabang_id", $user['cabang_id']);
        })->selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
            ->groupBy('year', 'month')->get()->toArray();
        $month = [];
        $data = [];

        foreach ($grafik as $attendances) {
            $month[] = $attendances['month'];
            $data[] = $attendances['data'];
        }

        $user = userInfo();

        $userCount = Users::where("cabang_id", $user['cabang_id'])->count();
        $scheduleCount = Schedules::where("cabang_id", $user['cabang_id'])->count();
        $regionCount = Regions::all()->count();

        return view('dashboard.index', ['title' => "Dashboard", 'users' => $userCount, 'schedules' => $scheduleCount, 'data' => $data, 'month' => $month, 'region' => $regionCount]);
    }
}
