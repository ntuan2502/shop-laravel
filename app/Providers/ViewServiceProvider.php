<?php

namespace App\Providers;

use App\Models\Shop;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $cart_taxPercent = config('cart.tax');
            $coupon = session()->get('coupon');
            $coupon_discount = $coupon['discount'] ?? 0;
            $coupon_name = $coupon['name'] ?? '';
            $cart_content = Cart::content();
            $cart_count = Cart::count();
            foreach ($cart_content as $item) {
                $item->vnd_price = pricetoVND($item->model->price);
                $item->vnd_subtotal = pricetoVND($item->subtotal);
            }
            $cart_subtotal = remove_thousand_seperator(Cart::subtotal());
            $cart_newSubtotal = $cart_subtotal - $coupon_discount;
            $cart_newTax = $cart_newSubtotal * $cart_taxPercent / 100;
            $cart_newTotal = $cart_newSubtotal + $cart_newTax;
            $shops = Shop::all();
            $currentRouteName = Route::currentRouteName();

            $view->with([
                'cart_content' => $cart_content,
                'cart_count' => $cart_count,
                'cart_subtotal' => pricetoVND($cart_subtotal),
                'coupon' => $coupon,
                'coupon_name' => $coupon_name,
                'coupon_discount' => pricetoVND($coupon_discount),
                'cart_newSubtotal' => pricetoVND($cart_newSubtotal),
                'cart_taxPercent' => $cart_taxPercent . '%',
                'cart_newTax' => pricetoVND($cart_newTax),
                'cart_newTotal' => pricetoVND($cart_newTotal),
                'shops' => $shops,
                'currentRouteName' => $currentRouteName,
                'request' => request(),
            ]);
        });
    }
}
