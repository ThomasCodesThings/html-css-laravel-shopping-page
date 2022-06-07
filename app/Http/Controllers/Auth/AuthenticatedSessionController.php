<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shoppingcart;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = User::find(Auth::user()->id);
        //create cart here
        session()->forget('cart');
        $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first(); 
        if($shoppingcart){
            $cartItems = CartItem::where('shoppingcart_id', $shoppingcart->id)->get();
            if($cartItems){
                $cart = [];
                foreach($cartItems as $item){
                    $cart[$item->product_id] = [
                            'product' => Product::findOrFail($item->product_id),
                            'quantity' => $item->quantity
                    ];   
                }
                if($cart){
                    session()->put('cart', $cart);
                    session()->save();
                }
            } 
        }
        else{
            Shoppingcart::create(['user_id' => $user->id,
            'ordered' => false,
            ]);   
        }
        if($user->hasRole("ADMIN")){
            return redirect()->intended(RouteServiceProvider::ADMIN);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
