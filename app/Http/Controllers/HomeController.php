<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $token = Session::get('jwt_token');

        if (!$token) {
            return redirect('/login');
        }

        $apiUrl = config('app.api_url') . '/products';

        $response = Http::withToken($token)->get($apiUrl);

        $products = $response->successful() ? $response->json() : [];
        // $products = [];

        return view('home', compact('products'));
    }
}
