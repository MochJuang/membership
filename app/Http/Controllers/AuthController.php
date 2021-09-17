<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Hash;
use Illuminate\Support\Facades\Auth; // baru


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function proses_login(Request $request)
    {
        $data = request()->validate([
	        'email' => 'required|email',
	        'password' => 'required',
        ]);

        // dd($data);

        Auth::attempt($data);
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
        	return redirect()->route('dashboard');
        } else { // false
	        Session::flash('error', 'Email Or password wrong');
	        return redirect()->route('login');
        }
    }
    public function logout(Request $request) {
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
    }
}