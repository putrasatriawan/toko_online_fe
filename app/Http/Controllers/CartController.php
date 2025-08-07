<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $apiBase;
    public function __construct()
    {
        $this->apiBase = config('app.api_url') . '/checkout';
    }
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'id'    => $id,
                'name'  => $request->name,
                'price' => (int)$request->price,
                'image' => $request->image,
                'qty'   => 1,
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['cart' => $cart]);
    }

    public function get()
    {
        return response()->json(['cart' => session('cart', [])]);
    }

    public function updateQty(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $change = $request->change;

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $change;

            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return response()->json(['cart' => $cart]);
    }
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|distinct',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $token = Session::get('jwt_token');

        $data = [
            'items' => $request->items
        ];

        $response = Http::withToken($token)->post($this->apiBase, $data);
        if ($response->successful()) {
            $message = $response->json()['message'];
            echo json_encode($message);
        }
    }
}
