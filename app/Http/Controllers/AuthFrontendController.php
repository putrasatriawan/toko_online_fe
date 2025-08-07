<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthFrontendController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $apiUrl = config('app.api_url') . '/login';

        $response = Http::post($apiUrl, [
            'email' => $request->email,
            'password' => $request->password
        ]);


        if ($response->successful()) {
            $data = $response->json();

            Session::put('jwt_token', $data['token']);
            Session::put('user_id', $data['user']['id']);
            Session::put('user_name', $data['user']['name']);
            Session::put('user_role', $data['user']['role']);
            Session::put('user_email', $data['user']['email']);

            if (strtolower($data['user']['role']) === 'admin') {
                return redirect()->route('admin.landing.index');
            }

            return redirect('/')->with('success', 'Login berhasil sebagai user biasa');
        }

        return back()->with('error', 'Login gagal, cek email/password');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $apiUrl = config('app.api_url') . '/register';

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Dummy data untuk testing
        $data = [
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => $request->password,
            'role'                  => 'customer',
        ];

        $response = Http::post($apiUrl, $data);

        // Tampilkan hasil response untuk debug
        // dd($response->json());

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
        } else {
            return back()->with('error', 'Gagal mendaftar. ' . $response->json('message'));
        }
    }


    public function logout()
    {
        Session::flush(); // hapus semua session
        return redirect('/login');
    }
}
