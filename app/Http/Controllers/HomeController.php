<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $token = Session::get('jwt_token');

        if (!$token) {
            return redirect('/login');
        }

        $search = $request->query('search');


        $apiUrl = config('app.api_url') . '/products';

        $queryParams = [];

        if ($search) {
            $queryParams['search'] = $search;
        }


        // dd($queryParams);
        $response = Http::withToken($token)->get($apiUrl, $queryParams);

        $products = $response->successful() ? $response->json() : [];

        return view('home', compact('products'));
    }
}
