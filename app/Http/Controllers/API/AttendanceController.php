<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Attendances;
use App\Models\Schedules;
use App\Models\Users;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function add(Request $request)
    {
        $rules = [
            'schedule_id' => 'required|exists:schedules,id,deleted_at,NULL',
            'persons' => 'required|integer',
        ];

        $messages = [
            'schedule_id.required' => 'The schedule id must not empty',
            'schedule_id.exists' => 'The schedule id cant be filled by that value',
            'persons.required' => 'The persons must not empty',
            'persons.integer' => 'The persons must an number',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Errors');

        try {
            $payload = $request->attributes->get('payload');

            $data = Attendances::where('user_id', $payload['id'])->where('schedule_id', $request->schedule_id)->count();

            if ($data > 0) throw new Exception("You can only make one attendance for the same date", 400);

            Schedules::addCurrentPeople($request->schedule_id, $request->persons);

            $code = uniqid() . uniqid(".");
            Attendances::create([
                'user_id' => $payload['id'],
                'schedule_id' => $request->schedule_id,
                'unique_code' => $code,
                'persons' => (int)$request->persons,
            ]);

            return ResponseFormatter::success([], "Success Add Attendance");
        } catch (Exception $err) {
            $message = $err->getMessage();
            $code = (int)$err->getCode();
            return ResponseFormatter::error($err, $message == '' ? 'Something went wrong' : $message, $code == 0 ? 500 : $code);
        }
    }

    public function setAttendance(Request $request)
    {
        try {
            $payload = $request->attributes->get('payload');

            $special_code = $request->special_code;
            $user = Users::where('special_code', $special_code)->with("region")->with("userVaccine")->first();

            if (!$user) throw new Exception("Can't Find User", 400);

            $currentSchedule = Schedules::where("cabang_id", $payload['cabang_id'])->where("date_event", date("Y-m-d"))->where("event_begin", ">=", date("Y-m-d H:i:s", strtotime("now") - 1800))->first();

            if (!$currentSchedule) throw new Exception("Can't Find current Schedule Please Check The Schedule Data", 400);

            $attendance = Attendances::where('schedule_id', $currentSchedule['id'])->where('user_id', $user->id)->first();

            if (!$attendance) throw new Exception("Belum terdaftar", 400);

            if ($attendance->isAttendance == 1) return ResponseFormatter::success(["user" => $user, "attendance" => $attendance], "Already Set Attendance");

            $attendance->isAttendance = 1;
            $attendance->save();

            return ResponseFormatter::success(["user" => $user, "attendance" => $attendance], 'Success Set Attendance');
        } catch (Exception $err) {
            $code = gettype($err->getCode()) != 'integer' ? 500 : $err->getCode();

            return ResponseFormatter::error([
                'message' => $err->getMessage(),
                'code' => $code,
            ], (!$err->getMessage()) ? "Something went wrong" : $err->getMessage(), $code);
        }
    }

    public function current(Request $request)
    {
        try {
            $payload = $request->attributes->get('payload');

            $attendance = Attendances::where("user_id", $payload['id'])->where('isAttendance', 0)->whereHas('schedule', function ($q) {
                $q->where("date_event", ">=", date("Y-m-d"))->latest();
            })->with("schedule.region")->latest()->first();


            return ResponseFormatter::success($attendance, "Success");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode() ?? 500);
        }
    }
}
