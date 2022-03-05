<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Regions;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\Validator;

class RegionsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $regions = Regions::all();

            return ResponseFormatter::success($regions, "Success Get Data!");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }


    public function add(Request $request)
    {
        $rules = [
            'name' => 'required|max:255|unique:regions',
            'unique_code' => 'required|max:2|unique:regions',
            'maps_link' => 'required|active_url',
        ];

        $messages = [
            'name.required' => 'Name field is required',
            'name.unique' => "Name field must unique!",
            'unique_code.required' => 'Unique code is required',
            'unique_code.unique' => "Unique Code must a unique value",
            'maps_link.required' => 'Maps link is required',
            'maps_link.active_url' => 'Maps link mus an active url'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Errors');

        try {
            Regions::create([
                'name' => $request->name,
                'unique_code' => $request->unique_code,
                'maps_link' => $request->maps_link,
            ]);

            return ResponseFormatter::success([], 'Success Add Data');
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Somethin went wrong', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'max:255|unique:regions,name',
            'maps_link' => 'active_url',
        ];

        $messages = [
            'name.unique' => "Name field must unique!",
            'maps_link.active_url' => 'Maps link mus an active url'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Errors');

        try {
            $region = Regions::find($id);

            if (!$region) throw new Exception("Can't find the region", 400);

            if ($request->name) {
                $region->name = $request->name;
            }

            if ($request->maps_link) {
                $region->maps_link = $request->maps_link;
            }

            $region->save();

            return ResponseFormatter::success([], 'Success Update');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $region = Regions::find($id);
            if (!$region) throw new Exception("Can't find the region", 400);

            $region->delete();

            return ResponseFormatter::success([], "Success Delete");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }
}
