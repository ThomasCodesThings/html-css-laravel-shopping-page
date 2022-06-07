<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\User;
use App\Models\Product;
use App\Models\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Shoppingcart;
use App\Models\CartItem;

class CheckoutController extends Controller
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
    public function create(Request $request)
    {
        $itemsInCart = session()->get('cart');
        if(!$itemsInCart)
            return view('pages.page.message')->with('message',"Fill please your shopping cart first.");
            
        $total = 0;
        foreach ($itemsInCart as $item)
            $total += ($item['product']->productPrice * $item['quantity']);
        $oldTotal = $total;
        if($request['couponCode']){
            $coupon = Coupon::where('coupon_code', $request['couponCode'])->get()->first();
            if($coupon){
                $current_date = date('Y-d-m');
                $current_date = date('Y-d-m', strtotime($current_date));
                $coupon_date = date('Y-d-m', strtotime($coupon->valid_until));

                if($current_date <= $coupon_date){
                    if(str_contains($coupon->discount, '%')){
                        $discount = intval(substr($coupon->discount, 0, -1));
                        $total = ($total * (100-$discount)) / 100;
                    }else{
                        $discount = intval($coupon->discount);
                        $total = $total - $discount;
                    }
                    if($total < 0){
                        $total = 0;
                    }
                }
            }
            #tu daj else ak nenajde kupon tak vypíše správu ak chceš(ale to netreba)
        }
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            return view('pages.page.checkout')->with('user',$user)->with('total',$total)->with('oldTotal', $oldTotal);
        }
        else return view('pages.page.checkout')->with('total',$total)->with('oldTotal', $oldTotal);
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
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'country' => 'required|string|min:3',
            'region' => 'required|string|min:3',
            'town' => 'required|string|min:3',
            'postalCode' => 'required|numeric',
            'street' => 'required|string|min:3',
            'payment' => 'required',
            'delivery' => 'required',
        ]);

        if(Auth::check()){
            $userID = Auth::user()->id;
            $cart = Shoppingcart::where('user_id',$userID)->where('ordered',false)->get()->first();
            $cart->update(['ordered' => true]);
            //vytvorenie noveho kosika
            $cart = Shoppingcart::create(['user_id' => $userID, 'ordered' => false]);
        }
        else{
            $userID = null;
            $cart = Shoppingcart::create(['userID' => $userID, 'ordered' => true]);
            $itemsInCart = session()->get('cart');

            if(empty($itemsInCart))
                return view('pages.page.message')->with('message',"Fill please your shopping cart first.");
            foreach ($itemsInCart as $item)
                CartItem::create(['shoppingcart_id' => $cart->id, 
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity']]);
        }

        $itemsInCart = session()->get('cart');
        $total = intval($request->total) + 5;

        #kontrola ci viem poslať vybaviť objednávku
        foreach ($itemsInCart as $item){
        $product = Product::where('id', $item['product']->id)->get()->first();
        if(intval($item['quantity']) > $product->productAmount){
            return view('pages.page.message')->with('message',"Order failed due to product shortage!");
        }
        }


        foreach ($itemsInCart as $item)
            $product = Product::where('id', $item['product']->id)->get()->first();
            Product::where('id', $item['product']->id)->update(['productAmount' => ($product->productAmount - intval($item['quantity']))]);

        Checkout::create(['name' => $request->name,
        'email' => $request->email,
        'userID' => $userID,
        'cartID' => $cart->id,
        'phone' => strval($request->preset).strval($request->phone), 
        'country' => $request->country,
        'region' => $request->region,
        'town' => $request->town,
        'postalCode' =>  $request->postalCode,
        'street' => $request->street,
        'details' => $request->details,
        'payment' => $request->payment,
        'delivery' => $request->delivery,
        'total' => $total,
    ]);
       
    unset($itemsInCart);
    session()->forget('cart');
    session()->save();
    return view('pages.page.message')->with('message',"Thank you for your order!");
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
}
