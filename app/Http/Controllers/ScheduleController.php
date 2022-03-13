<?php

namespace App\Http\Controllers;

use App\Helpers\SendNotification;
use App\Models\Schedules;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    private $announcementHelpers;

    function __construct()
    {
        $this->announcementHelpers = new SendNotification();
    }

    public function index(Request $request)
    {
        $user = userInfo();

        $schedules = Schedules::where('cabang_id', $user['cabang_id'])->with('region')->get()->toArray();

        return view('schedule.index', ['schedules' => $schedules, 'title' => 'Schedules']);
    }

    public function create(Request $request)
    {
        return view("schedule.create", ['title' => 'Schedules Create']);
    }

    public function add(Request $request)
    {
        $request->validate([
            'date' => "required",
            'max_people' => "required",
            'begin' => "required",
            'end' => "required",
        ]);

        $user = userInfo();

        $date = $request->date;
        $begin = $date . " " . $request->begin . ":00";
        $end = $date . " " . $request->end . ":00";

        Schedules::create([
            'cabang_id' => $user['cabang_id'],
            'max_people' => $request->max_people,
            'event_begin' => $begin,
            'event_end' => $end,
            'date_event' => $date,
        ]);

        $this->announcementHelpers->broadcastLocal('New Schedule Added', 'Ada schedule ibadah baru nih!', ['url' => 'schedule']);

        return redirect("/schedule")->with("success_form", "Success Add Data!");
    }

    public function edit(Request $request, $id)
    {
        $schedule = Schedules::find($id);

        $schedule = [
            'id' => $schedule->id,
            'date' => $schedule->date_event,
            'begin' => explode(" ", $schedule->event_begin)[1],
            'end' => explode(" ", $schedule->event_end)[1],
            'max_people' => $schedule->max_people,
        ];

        return view('schedule.edit', ['schedule' => $schedule, 'title' => 'Schedule Edit']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => "required",
            'max_people' => "required",
            'begin' => "required",
            'end' => "required",
        ]);

        $schedule = Schedules::find($id);

        $schedule->date_event = $request->date;
        $schedule->max_people = $request->max_people;
        $schedule->event_begin = $request->date . " " . $request->begin;
        $schedule->event_end = $request->date . " " . $request->end;
        $schedule->save();

        return redirect('/schedule')->with("success_form", "Success Edit Data!");
    }

    public function delete(Request $request, $id)
    {
        Schedules::find($id)->delete();

        return redirect("/schedule")->with("warning_form", 'Success Delete Data !');
    }

    public function resetSchedule(Request $request)
    {
        $user = userInfo();

        $schedules = Schedules::where('cabang_id', $user['cabang_id'])->with('region')->get();

        foreach ($schedules as $schedule) {
            $oneWeek = 60 * 60 * 24 * 7;

            $newDate = strtotime($schedule->date_event);
            $newDate = date("Y-m-d", $newDate + $oneWeek);

            $eventBegin = explode(" ", $schedule->toArray()['event_begin']);
            $eventEnd = explode(" ", $schedule->toArray()['event_end']);

            $newEventBegin = $newDate . " " . end($eventBegin);
            $newEventEnd = $newDate . " " . end($eventEnd);


            Schedules::create([
                'cabang_id' => $schedule->cabang_id,
                'max_people' => $schedule->max_people,
                'event_begin' => $newEventBegin,
                'event_end' => $newEventEnd,
                'date_event' => $newDate,
            ]);
        }

        $schedules->each(function ($data, $key) {
            $data->delete();
        });
        $this->announcementHelpers->broadcastLocal("New Schedule Available!", 'Jadwal ibadah terbaru sudah tersedia nih, yuk daftar!', ['url' => 'schedule']);
        return redirect("/schedule")->with("warning_form", 'Success Reset Data !');
    }

    public function deleteActive(Request $request)
    {
        $user = userInfo();

        $schedules = Schedules::where('cabang_id', $user['cabang_id'])->with('region')->get();
        $schedules->each(function ($data, $key) {
            $data->delete();
        });

        return redirect("/schedule")->with("warning_form", 'Success Clear Data !');
    }
}
