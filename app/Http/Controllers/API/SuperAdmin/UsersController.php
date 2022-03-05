<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function updateRole(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'role' => 'required|in:admin,superadmin,user',
        ], [
            'role.required' => "Role is Required",
            'role.in_array' => "Can't accept that value",
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors(), 'Errors', 402);
        }

        try {
            $user = User::find($id);
            $user->role = $request->role;
            $user->save();

            return ResponseFormatter::success($user);
        } catch (Exception $err) {
            return ResponseFormatter::error($err, 'Something Went Wrong!', 500);
        }
    }
}
