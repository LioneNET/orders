<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        return ProductResource::collection(Product::query()->paginate());
    }

    public function show(Product $product) {
        return ProductResource::make($product);
    }
}
