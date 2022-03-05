<?php

namespace App\Http\Controllers\API;

use App\Helpers\JWTGenerator;
use App\Helpers\OtpHelpers;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Regions;
use App\Models\Users;
use App\Models\UsersVaccine;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'phone_number' => 'required|exists:users,phone_number',
            'password' => 'required|max:255',
        ];

        $messages = [
            'phone_number.exists' => 'The Phone Number Is Not Exists',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Users Input Invalid. Errors!');
        try {

            $user = Users::where('phone_number', $request->phone_number)->first();

            if (!$user) throw new Exception("Can't Find Users", 400);

            if (!Hash::check($request->password, $user->password, []))  throw new Exception("Invalid Password or Phone Number", 400);

            $userOtp = OtpHelpers::createOtp($user->id);

            return ResponseFormatter::success($userOtp, 'Otp Has Been Send To The phone number');
        } catch (Exception $err) {

            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function verifyOtp(Request $request)
    {

        $rules = [
            'special_code' => "required|exists:users,special_code",
            'otp' => 'required'
        ];

        $messages = [
            'special_code.required' => 'special code must not empty',
            'special_code.exists' => "Can't find user",
            'otp.required' => "Need Otp"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), "Error", 400);

        try {
            $special_code = $request->special_code;

            $user = Users::where("special_code", $special_code)->first();

            if (!OtpHelpers::validateOtp($user, $request->otp)) throw new Exception("Wrong Code, Cant Verified", 400);

            $user->otp = null;
            $user->otp_exp = null;
            $user->phone_number_verified_at = date("Y-m-d H:i:s", strtotime('now'));
            $user->save();

            $token = JWTGenerator::getToken($user);
            return ResponseFormatter::success([
                'user' => $user,
                'token' => $token,
            ], "Success verify");
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function regenerateOtp(Request $request)
    {
        $rules = [
            'special_code' => 'required|exists:users,special_code',
        ];

        $messages = [
            'special_code.required' => 'Special code must not empty',
            'special_code.exists' => "can't find the users"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Error', 400);

        try {
            $user = Users::where("special_code", $request->special_code)->first();

            $userOtp = OtpHelpers::createOtp($user->id);

            return ResponseFormatter::success($userOtp, 'Success');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'full_name' => 'required|unique:users,full_name|max:255',
            'phone_number' => 'required|unique:users,phone_number|min:12',
            'cabang_id' => 'required|exists:regions,id',
            'address' => 'required',
            'password' => 'required|max:255|min:8',
        ];

        $messages = [
            'full_name.required' => "The Field is required",
            'full_name.unique' => 'The Field is Already Exist',
            'phone_number.unique' => 'The Field is Already Exist',
            'cabang_id.exists' => 'The Field Must Exist',
            'password.min' => 'Password Must Have Lenth Min 8',
        ];
        try {
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Validators Error');

            $region = Regions::find($request->cabang_id);
            $bytes = random_bytes(15);
            $unique = $region->unique_code . '-' . bin2hex($bytes);

            $users = Users::create([
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'cabang_id' => $request->cabang_id,
                'special_code' => $unique,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                "picture_path" => "users/default.jpeg",
            ]);


            $userOtp = OtpHelpers::createOtp($users->id);

            return  ResponseFormatter::success($userOtp, 'User Registered! Please verify the Otp');
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => "Something went wrong",
                'error' => $err,
            ], 'Error');
        }
    }

    public function forgotPassword(Request $request)
    {
        $rules = [
            'phone_number' => 'required|exists:users,phone_number',
        ];

        $messages = [
            'phone_number.required' => "Phone Number must not empty",
            'phone_number.exists' => "Can't find users",
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Error', 400);

        try {
            $user = Users::where("phone_number", $request->phone_number)->first();
            $userOtp = OtpHelpers::createOtp($user->id);

            return ResponseFormatter::success($userOtp, 'Please insert the otp');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'password' => 'required|min:8|max:255',
            'special_code' => 'required|exists:users,special_code'
        ];

        $messages = [
            'password.required' => "password must not empty",
            'special_code.required' => 'Special code must not empty',
            'special_code.exists' => "Can't find user"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), 'Error', 400);

        try {
            $user = USers::where("special_code", $request->special_code)->first();
            if ($user->otp_exp) throw new Exception("Please Verify The Otp First", 401);
            $user->password = Hash::make($request->password);
            $user->save();


            return  ResponseFormatter::success([], 'Success change password!');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function addVaccine(Request $request)
    {
        $rules = [
            "image" => "required|image",
            'vaccine_date' => "required|date",
        ];
        $messages = [];
        Validator::make($request->all(), $rules, $messages);

        try {
            $payload = $request->attributes->get('payload');
            $fileName =  $request->file('image')->hashName();
            Storage::disk("privateDisk")->put("vaccinate", $request->file('image'));

            UsersVaccine::create([
                'user_id' => $payload['id'],
                'path_image' => $fileName,
                'vaccine_date' => $request->vaccine_date,
                'description' => $request->description,
            ]);

            return ResponseFormatter::success([], 'Success Add Data');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }


    public function showVaccinePicture($filename)
    {
        try {

            $profile_path = storage_path('app/private/vaccinate/' . $filename);


            return response()->file($profile_path);
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }

    public function addProfilePicture(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'profile_picture' => "required|image"
        ]);

        if ($validator->fails()) return ResponseFormatter::error($validator->errors(), "Form Error");


        try {


            $payload = $request->attributes->get("payload");

            $user = Users::find($payload['id']);

            if ($request->file('profile_picture')) {
                $temp_picture_path = explode(env("APP_URL") . "/" . "storage/", $user['picture_path']);
                $picturePathFile = end($temp_picture_path);
                if ($user['picture_path'] && Storage::exists($picturePathFile)) {
                    Storage::delete($picturePathFile);
                }

                $fileName = $request->file('profile_picture')->store('users');
                $user->picture_path = $fileName;
                $user->save();
            }

            return ResponseFormatter::success($user, 'Success Add Profile Picture');
        } catch (Exception $err) {
            return ResponseFormatter::error([], $err->getMessage(), $err->getCode());
        }
    }
}
