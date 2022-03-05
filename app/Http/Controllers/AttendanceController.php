<?php

namespace App\Http\Controllers;

use App\Models\Attendances;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attendances = Attendances::whereMonth("created_at", date('m'))->whereYear('created_at', date('Y'))->whereHas("schedule", function ($q) {
            $user = userInfo();
            $q->where("cabang_id", $user['cabang_id']);
        })->with(['user', 'schedule', 'schedule.region'])->get()->toArray();

        return view('attendance.index', ['attendances' => $attendances, 'title' => "Attendance"]);
    }

    public function history()
    {
        $dataTime = Attendances::withTrashed()->whereHas('schedule', function ($q) {
            $user = userInfo();
            $q->where('cabang_id', $user['cabang_id']);
        })->get('created_at')->toArray();

        $datafixed = [];

        foreach ($dataTime as $data) {
            $datafixed[date("F", $data['created_at'])] = [
                'year' => date("Y", $data['created_at']),
                'month' => date("F", $data['created_at']),
            ];
        }


        return view('attendance.history', ['attendances' => $datafixed, 'title' => "Attendance History"]);
    }

    public function historyData($year, $month)
    {
        $data = Attendances::withTrashed()->whereHas("scheduleAll", function ($q) {
            $user = userInfo();
            $q->where("cabang_id", $user['cabang_id']);
        })->whereMonth("created_at", date('m', strtotime($month)))->whereYear('created_at', date('Y', strtotime($year)))->with(['user', 'scheduleAll', 'scheduleAll.region'])->get()->toArray();

        return view('attendance.history_index', ['attendances' => $data, 'date' => $year . " " . $month, 'title' => "Attendance History"]);
    }
}
