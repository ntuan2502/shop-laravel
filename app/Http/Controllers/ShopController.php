<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 9;
        if (request()->shop) {
            $products = Product::with('shops')->whereHas('shops', function ($query) {
                $query->where('slug', request()->shop);
            })->get();
            $countProducts = $products->count();
            $currentShop = Shop::where('slug', request()->shop)->first();
        } else {
            $products = Product::where([])->inRandomOrder()->get();
            $countProducts = $products->count();
            $currentShop = 'Shop';
        }
        //$products = $products->paginate($pagination);

        foreach ($products as $product) {
            $product->vnd_price = pricetoVND($product->price);
        }

        return view('shop')->with([
            'products' => $products,
            'currentShop' => $currentShop,
            'countProducts' => $countProducts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::where('slug', '!=', $slug)->relatedProducts()->get();

        $product->vnd_price = pricetoVND($product->price);
        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->vnd_price = pricetoVND($relatedProduct->price);
        }

        $currentShop = Shop::with('products')->whereHas('products', function ($query) use ($product) {
            $query->where('slug', $product->slug);
        })->firstOrFail();

        return view('product')->with([
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'currentShop' => $currentShop,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
