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

    public function update(Request $request)
    {
        $index = (int) $request->index;
        $data = json_decode(Storage::get('products.json'), true) ?? [];

        if (!isset($data[$index])) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $data[$index]['product_name'] = $request->product_name;
        $data[$index]['quantity'] = (int) $request->quantity;
        $data[$index]['price'] = (float) $request->price;
        $data[$index]['total'] = $data[$index]['quantity'] * $data[$index]['price'];
        Storage::put('products.json', json_encode($data, JSON_PRETTY_PRINT));
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        
    }
}
