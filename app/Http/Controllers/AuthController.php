<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('user.login');
    }

    public function signup()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')->with('failed', 'Ada Kesalahan dalam Input Data');
        } else {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $success['name'] = $user->name;
            $success['email'] = $user->email;

            return redirect()->route('login')->with('success', 'Anda berhasil melakukan Registrasi, Please Login');
        }
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['email'] = $auth->email;

            return redirect()->route('dashboard')->with('success', 'Anda Berhasil Login');
        } else {
            return redirect()->route('login')->with('failed', 'Ada Kesalahan pada E-mail dan Password');
        }
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda Berhasil Logout');
    }
}
