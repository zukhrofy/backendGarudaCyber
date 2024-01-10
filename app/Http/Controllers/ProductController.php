<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductsByTenant($tenantId)
    {
        $products = Product::where('tenant_id', $tenantId)->get();
        return response()->json($products);
    }
}
