<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BuyerController extends Controller
{
    public function trackingBuyer(Request $request)
    {
        $token = Session::get('jwt_token');

        $id = session('user_id');

        if (!$token) {
            return redirect('/login');
        }

        $apiUrl = config('app.api_url') . '/order-user/' . $id;

        $response = Http::withToken($token)->get($apiUrl);

        $orders = $response->successful() ? $response->json() : [];

        return response()->json($orders);
    }
}
