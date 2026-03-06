<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{

    public function __invoke(Request $request)
    {

        $query = Product::inStock();

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($search = $request->search) {
            $query->where(fn($q) =>
            $q->where('name','like',"%$search%")
                ->orWhere('sku','like',"%$search%")
            );
        }

        $key = md5(http_build_query($request->all()));
        return Cache::remember("product_list_{$key}", 500, function() use($query){
            return ProductResource::collection(
                $query->paginate()
            );
        });
    }
}
