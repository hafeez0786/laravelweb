<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasPermission('view_products')) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Sample products data
        $products = [
            ['id' => 1, 'name' => 'Laptop Pro', 'category' => 'Electronics', 'price' => 1299.99, 'status' => 'In Stock'],
            ['id' => 2, 'name' => 'Wireless Mouse', 'category' => 'Electronics', 'price' => 29.99, 'status' => 'In Stock'],
            ['id' => 3, 'name' => 'USB-C Hub', 'category' => 'Accessories', 'price' => 49.99, 'status' => 'Limited Stock'],
            ['id' => 4, 'name' => 'Mechanical Keyboard', 'category' => 'Electronics', 'price' => 149.99, 'status' => 'In Stock'],
            ['id' => 5, 'name' => 'Monitor Stand', 'category' => 'Accessories', 'price' => 39.99, 'status' => 'Out of Stock'],
        ];

        return view('products.index', compact('products'));
    }

    /**
     * Display the specified product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Sample product data
        $product = [
            'id' => $id,
            'name' => 'Laptop Pro',
            'description' => 'High-performance laptop with advanced features for professionals. Includes latest processor, ample RAM, and stunning display.',
            'category' => 'Electronics',
            'price' => 1299.99,
            'status' => 'In Stock',
            'features' => ['Intel Core i7', '16GB RAM', '512GB SSD', '15.6" Display', 'Backlit Keyboard'],
            'specifications' => [
                'Processor' => 'Intel Core i7-11th Gen',
                'RAM' => '16GB DDR4',
                'Storage' => '512GB NVMe SSD',
                'Display' => '15.6" Full HD',
                'Graphics' => 'NVIDIA GTX 1650',
                'Battery' => '8 hours backup'
            ]
        ];

        return view('products.show', compact('product', 'id'));
    }
}
