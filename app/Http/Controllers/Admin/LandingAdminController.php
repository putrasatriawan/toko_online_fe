<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;


class LandingAdminController extends Controller
{
    public function index()
    {
        $token = Session::get('jwt_token');
        $response = Http::withToken($token)->get(config('app.api_url') . '/dashboard-summary');

        $data = $response->successful() ? $response->json() : [];

        return view('admin.landing.index', compact('data'));
    }
}
