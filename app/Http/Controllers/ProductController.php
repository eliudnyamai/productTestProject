<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $data = json_decode(Storage::get('products.json'), true) ?? [];
        
        return response()->json(['data' => $data]);
    }

    public function show($id)
    {
        // Logic to retrieve and return a single product by ID
    }

    public function store(Request $request)
    {
        $data = json_decode(Storage::get('products.json'), true) ?? [];

        $entry = [
            'product_name' => $request->product_name,
            'quantity' => (int) $request->quantity,
            'price' => (float) $request->price,
            'datetime' => now()->toDateTimeString(),
            'total' => (int) $request->quantity * (float) $request->price
        ];

        $data[] = $entry;
        Storage::put('products.json', json_encode($data, JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing product by ID
    }

    public function destroy($id)
    {
        // Logic to delete a product by ID
    }
}
