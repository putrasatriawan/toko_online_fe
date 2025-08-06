<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProductCmsController extends Controller
{
    protected $apiBase;

    public function __construct()
    {
        $this->apiBase = config('app.api_url') . '/products';
    }

    public function index(Request $request)
    {
        $token = Session::get('jwt_token');
        $query = $request->input('search'); // ambil search query dari form

        $url = $this->apiBase;
        if ($query) {
            $url .= '?search=' . urlencode($query);
        }

        $response = Http::withToken($token)->get($url);

        $products = $response->successful() ? $response->json() : [];

        return view('admin.products.index', compact('products', 'query'));
    }


    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $token = Session::get('jwt_token');

        $cleanedPrice = str_replace('.', '', $request->price);

        $data = [
            'name'  => $request->name,
            'description'  => $request->description,
            'price' => $cleanedPrice,
            'stock' => $request->stock,
        ];

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageData = base64_encode(file_get_contents($imageFile));
            $mimeType = $imageFile->getMimeType();

            $data['image'] = 'data:' . $mimeType . ';base64,' . $imageData;
        }

        // DD($data);
        $response = Http::withToken($token)->post($this->apiBase, $data);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
        }

        return back()->with('error', 'Gagal menambahkan produk.');
    }


    public function edit($id)
    {
        $token = Session::get('jwt_token');
        $response = Http::withToken($token)->get($this->apiBase . '/' . $id);

        if ($response->successful()) {
            $product = $response->json();
            return view('admin.products.edit', compact('product'));
        }

        return redirect()->route('admin.products.index')->with('error', 'Produk tidak ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $token = Session::get('jwt_token');

        $data = [
            'name'  => $request->name,
            'price' => str_replace('.', '', $request->price), // hilangkan titik
            'stock' => $request->stock,
        ];


        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageData = base64_encode(file_get_contents($imageFile));

            $mimeType = $imageFile->getMimeType();

            $data['image'] = 'data:' . $mimeType . ';base64,' . $imageData;
        }

        // dd($data);

        $response = Http::withToken($token)->put($this->apiBase . '/' . $id, $data);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate.');
        }

        return back()->with('error', 'Gagal mengupdate produk.');
    }


    public function destroy($id)
    {
        $token = Session::get('jwt_token');

        $response = Http::withToken($token)->delete($this->apiBase . '/' . $id);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus produk.');
    }
}
