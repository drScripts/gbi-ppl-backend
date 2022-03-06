<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Schedules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchedulesController extends Controller
{
    public function add(Request $request)
    {
        $rules = [
            'cabang_id' => 'required|exists:regions,id',
            'date_event' => "required|date",
            'event_begin' => 'required|date',
            'event_end' => 'required|date',
            'max_people' => 'required|integer',
        ];

        $messages = [
            'cabang_id.required' => 'Cabang must not empty',
            'cabang_id.exists' => "Cabang not can't filled with that value",
            'date_event.required' => 'Date event must not empty',
            'date_event.date' => 'Date event must a date',
            'event_begin.required' => 'Event begin must not empty',
            'event_begin.date' => 'Event begin must a timestamp',
            'event_end.required' => 'Event end must not empty',
            'event_end.date' => 'Event end must a timestamp',
            'max_people.required' => "Max People must not empty",
            'max_people.integer' => "Max people must an integer",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Errors');

        try {
            Schedules::create([
                'cabang_id' => $request->cabang_id,
                'date_event' => $request->date_event,
                'event_begin' => $request->event_begin,
                'event_end' => $request->event_end,
                'max_people' => $request->max_people,
            ]);

            return ResponseFormatter::success([], 'Success Add Schedules');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Somthing went wrong', 500);
        }
    }



    public function update(Request $request, $id)
    {
        $rules = [
            'date_event' => "date",
            'event_begin' => 'date',
            'event_end' => 'date',
            'max_people' => 'integer',
        ];

        $messages = [
            'date_event.date' => 'Date event must a date',
            'event_begin.date' => 'Event begin must a timestamp',
            'event_end.date' => 'Event end must a timestamp',
            'max_people.integer' => "Max people must an integer",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Errors');
        try {
            $schedules = Schedules::find($id);

            if (!$schedules) throw new Exception("Can't find schedules", 400);

            $event_begin = $request->event_begin;
            $event_end = $request->event_end;
            $date_event = $request->date_event;
            $max_people = $request->max_people;

            if ($event_begin) {
                $schedules->event_begin = $event_begin;
            }
            if ($event_end) {
                $schedules->event_end = $event_end;
            }

            if ($date_event) {
                $schedules->date_event = $date_event;
            }

            if ($max_people) {
                $schedules->max_people = $max_people;
            }

            $schedules->save();

            return ResponseFormatter::success([], 200);
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode() == 0 ? 500 : $err->getCode());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $schedules = Schedules::find($id);
            if (!$schedules) throw new Exception("Can't find the schedules", 400);

            $schedules->delete();

            return ResponseFormatter::success([], "Success Delete Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function reset(Request $request, $id)
    {
    }

    public function deleteAll(Request $request, $id)
    {
    }

    public function available(Request $request)
    {
        try {
            $payload = $request->attributes->get('payload');

            $schedules = Schedules::with("region")->where('cabang_id', $payload['cabang_id'])->where("date_event", '>=', date("Y-m-d"))->where("event_begin", ">=", date("Y-m-d H:i:s", strtotime("now") - 1800))->get();

            return ResponseFormatter::success($schedules, "Success Get Data");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }
}
