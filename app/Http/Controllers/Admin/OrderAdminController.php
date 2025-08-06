<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderAdminController extends Controller
{
    protected $apiBase;

    public function __construct()
    {
        $this->apiBase = config('app.api_url') . '/orders';
    }

    public function index(Request $request)
    {
        $token = Session::get('jwt_token');

        // $search = $request->query('search');

        $response = Http::withToken($token)->get($this->apiBase);
        // dd($response->json());

        $orders = $response->successful() ? $response->json() : [];

        return view('admin.orders.index', compact('orders',));
    }

    public function show($id)
    {
        $token = Session::get('jwt_token');

        $response = Http::withToken($token)->get($this->apiBase . '/' . $id);
        // dd($response->json());
        if ($response->successful()) {
            $order = $response->json();
            return view('admin.orders.show', compact('order'));
        }

        return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak ditemukan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $token = Session::get('jwt_token');

        $response = Http::withToken($token)->put($this->apiBase . '/' . $id, [
            'status' => $request->status
        ]);
        // dd($response);


        if ($response->successful()) {
            return redirect()->route('admin.orders.show', $id)->with('success', 'Status pesanan diperbarui.');
        }

        return back()->with('error', 'Gagal mengubah status.');
    }

    public function destroy($id)
    {
        $token = Session::get('jwt_token');

        $response = Http::withToken($token)->delete($this->apiBase . '/' . $id);

        if ($response->successful()) {
            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus pesanan.');
    }
}
