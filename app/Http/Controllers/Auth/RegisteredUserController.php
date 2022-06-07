<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shoppingcart;
use App\Models\CartItem;
use App\Models\Product;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $cart = session()->get('cart');
        if($cart){
            $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first(); 
            if(!$shoppingcart){
                $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
            }
            if($shoppingcart){
                foreach($cart as $product){
                    CartItem::create(['shoppingcart_id' => $shoppingcart->id, 
                    'product_id' => $product['product']->id,
                    'quantity' => $product['quantity']]);
                }
            }
        }

        event(new Registered($user));

        Auth::login($user);
        return view('pages.page.message')->with('message',"Account created.");
    }
}
