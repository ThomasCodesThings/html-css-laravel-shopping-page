<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
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
        $coupons = Coupon::all();
        return view('pages.admin.viewcoupons',compact('coupons',$coupons));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.createcoupon');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|min:3',
            'discount' => 'required',
            'valid_until' => 'nullable|date',
        ]);

        $coupon = Coupon::create(['coupon_code' => $request->coupon_code,
        'discount' => $request->discount, 
        'valid_until' => $request->valid_until]);
          
        /*redirect na funkciu show*/
        return redirect('/coupons/'.$coupon->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        return view('pages.admin.showcoupon',compact('coupon', $coupon));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('pages.admin.editcoupon',compact('coupon',$coupon));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'coupon_code' => 'required|min:3',
            'discount' => 'required',
            'valid_until' => 'nullable|date',
        ]);  
             
        $coupon->coupon_code = $request->coupon_code ;
        $coupon->discount = $request->discount ;
        $coupon->valid_until = $request->valid_until ;
        $coupon->save();
        $request->session()->flash('message', 'Data succesfully changed.');
          
        return redirect('coupons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Coupon $coupon)
    {
        $coupon->delete();
        $request->session()->flash('message', 'Coupon deleted succesfully.');
        return redirect('coupons');
    }
}
