<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'phone_number' => "required|exists:users,phone_number",
            'password' => 'required',
        ]);

        $phoneNumber = $request->phone_number;
        $password = $request->password;

        $user = User::where("phone_number", $phoneNumber)->first();
        if ($user->role != "admin" && $user->role != 'superadmin') return back()->with("failed_status", "Anda Tidak Dapat Masuk Kesini! Hanya Admin yang dapat masuk ke sini!");
        $check = Hash::check($password, $user->password);

        if (!$check) return back()->with("failed_status", "Nomor telepon atau password anda salah!")->withInput();

        session(['user' => $user->toArray()]);

        return redirect('/');
    }

    public function logout(Request $request)
    {
        session()->pull("user");

        return redirect("/");
    }
}
