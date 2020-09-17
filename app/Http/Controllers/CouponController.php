<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            return redirect()->route('cart.index')->withErrors('Invalid coupon code. Please try again.');
        }
        $discount = 0;
        $cart_subtotal = remove_thousand_seperator(Cart::subtotal());
        if ($coupon->type == 'fixed') {
            if ($cart_subtotal < $coupon->min_price) {
                return redirect()->route('cart.index')->withErrors('Giá tiền nhỏ hơn yêu cầu coupon.');
            } else {
                $discount = $coupon->discount($cart_subtotal);
            }
        } elseif ($coupon->type == 'percent') {
            if ($coupon->discount($cart_subtotal) > $coupon->max_discount) {
                $discount = $coupon->max_discount;
            } elseif ($cart_subtotal < $coupon->min_price) {
                return redirect()->route('cart.index')->withErrors('Giá tiền nhỏ hơn yêu cầu coupon.');
            } else {
                $discount = $coupon->discount($cart_subtotal);
            }
        }
        session()->put('coupon', [
            'name' => $coupon->code,
            'discount' => $discount,
        ]);

        return redirect()->route('cart.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        session()->forget('coupon');
        return redirect()->route('cart.index');
    }
}
