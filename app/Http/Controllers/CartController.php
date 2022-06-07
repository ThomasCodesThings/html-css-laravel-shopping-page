<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Shoppingcart;
use App\Models\CartItem;

class CartController extends Controller
{
    public function show(){
        //session()->invalidate();
       if(Auth::user()){
        $user = User::find(Auth::user()->id);
        $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first();
        if(!$shoppingcart){
            $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
        } 
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
    }
    if(session()->get('cart') == null){
        return view('pages.page.message')->with('message',"Your cart is empty :(");
    }
    return view('pages.page.cart', ['cart' => session()->get('cart')]);
}

    public function add(Request $request){
        $product = json_decode($request->product);
        if($product->productAmount < $request->amount){
            return redirect()->back();
        }
        if(!$product || !$request->amount){
            return redirect()->back();
        }
        if($request->amount <= 0){
           return redirect()->back();
        }
        $cart = session()->get('cart');
        if(!$cart){
            $cart = [
                $product->id => [
                    'product' => $product,
                    'quantity' => $request->amount
                   ]
                ];
                session()->put('cart', $cart);
                session()->save();
                if(Auth::user()){
                    $user = User::find(Auth::user()->id);
                    $shoppingcart = Shoppingcart::where('user_id',$user->id)->where('ordered',false)->get()->first();
                    if(!$shoppingcart){
                        $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
                    }
                    CartItem::create(['shoppingcart_id' => $shoppingcart->id, 
                    'product_id' => $product->id,
                    'quantity' => $request->amount]);
                }
                return redirect()->route('display-cart')->with('message', 'Product was added to cart successfully!');
           }
       if(isset($cart[$product->id])){
           $cart[$product->id]['quantity'] += $request->amount;
           if(Auth::user()){
                $user = User::find(Auth::user()->id);
                $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first();
                if(!$shoppingcart){
                    $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
                }
                $cartitem = CartItem::where('shoppingcart_id', $shoppingcart->id)->where('product_id', $product->id)->get()->first();
                $cartitem->update(['quantity' => ($cartitem->quantity + $request->amount)]);
            }
           session()->put('cart', $cart);
           session()->save();
           return redirect()->route('display-cart')->with('message', 'Product was added to cart successfully!');
       }
       $cart[$product->id] = [
           'product' => $product,
           'quantity' => $request->amount
       ];
       if(Auth::user()){
            $user = User::find(Auth::user()->id);
            $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first();
            if(!$shoppingcart){
                $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
            }
            CartItem::create(['shoppingcart_id' => $shoppingcart->id, 
            'product_id' => $product->id,
            'quantity' => $request->amount]);
        }
       //Product::where('id', $product->id)->update(['productAmount' => ($product->productAmount - $request->amount)]);
       session()->put('cart', $cart);
        session()->save();
       return redirect()->route('display-cart')->with('message', 'Product was added to cart successfully!');
       }

       public function update(Request $request){
           $cart = session()->get('cart');
           if($cart){
               if($request['newAmount'] == 0){
                    unset($cart[$request['productID']]);
                    if(Auth::user()){
                        $user = User::find(Auth::user()->id);
                        $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first();
                        if(!$shoppingcart){
                            $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
                        }
                        $cartitem = CartItem::where('shoppingcart_id', $shoppingcart->id)->where('product_id', $request['productID'])->get()->first();
                        $cartitem->delete();
                    }
                    session()->put('cart', $cart);
                    session()->save();
                    if(session()->get('cart') == null){
                        return view('pages.page.message')->with('message',"Your cart is empty :(");
                    }
                    return view('pages.page.cart', ['cart' => session()->get('cart')]);
               }
               $cart[$request['productID']]['quantity'] = $request['newAmount'];
               if(Auth::user()){
                $user = User::find(Auth::user()->id);
                $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first();
                if(!$shoppingcart){
                    $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
                }
                $cartitem = CartItem::where('shoppingcart_id', $shoppingcart->id)->where('product_id', $request['productID'])->get()->first();
                $cartitem->update(['quantity' => $request['newAmount']]);
            }
               session()->put('cart', $cart);
               session()->save();
               return view('pages.page.cart', ['cart' => session()->get('cart')]);
           }
           return redirect()->back();
       }

       public function delete(Request $request){
           
           if($request->has('productID')){
            $cart = session()->get('cart');
            unset($cart[$request['productID']]);
            if(Auth::user()){
                $user = User::find(Auth::user()->id);
                $shoppingcart = Shoppingcart::where('user_id', $user->id)->where('ordered', false)->get()->first();
                if(!$shoppingcart){
                    $shoppingcart = Shoppingcart::create(['user_id' => $user->id, 'ordered' => false])->get()->first();
                }
                $cartitem = CartItem::where('shoppingcart_id', $shoppingcart->id)->where('product_id', $request['productID'])->get()->first();
                $cartitem->delete();
            }
            session()->put('cart', $cart);
            session()->save();
           
           return redirect()->route('display-cart')->with('message', 'Product was removed from cart!');
       }
    }
}
