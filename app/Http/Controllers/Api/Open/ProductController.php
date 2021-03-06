<?php

namespace CodeShopping\Http\Controllers\Api\Open;

use Illuminate\Http\Request;
use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Resources\Open\ProductResource as OpenProductResource;
use CodeShopping\Models\Product;
use CodeShopping\Http\Filters\Open\ProductFilter as OpenProductFilter;
use CodeShopping\Http\Resources\Open\ProductPhotoCollection as OpenProductPhotoCollection;

class ProductController extends Controller
{

    public function index()
    {
        $filter = app(OpenProductFilter::class);
        $filterQuery = Product::filtered($filter);
        $products = $filterQuery->where('active', true)->where('stock','>',0)->paginate();
        return OpenProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product = Product::where('active', true)
                    ->where('stock','>',0)
                    ->where('id', $product->id)
                    ->firstOrFail();
        return new OpenProductPhotoCollection($product->photos, $product);
    }

}
