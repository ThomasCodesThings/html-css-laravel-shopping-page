<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Poll;
use App\Models\Option;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public $brands = [];
    public $maxPrice = 0;

    private function get_poll(){
        $polls = Poll::all();
        $date = now();
        foreach($polls as $poll){
            if($poll->date_from < $date && $poll->date_to > $date){
                $options = Option::where('poll_id', $poll->id);
                if($options->count() > 2){
                    return $poll;
                }
            }
        }


        return null;
    }

    public function mainpage()
    {
        $discountProducts = Product::where('productDiscount', true)->take(7)->get();
        $newProducts = Product::latest('created_at')->take(7)->get();

        $current_poll = $this->get_poll();
        $already_voted = false;
        if(Auth::user()){
            foreach(Vote::all() as $vote){
                if($vote->user_id == Auth::user()->id && $vote->poll_id == $current_poll->id){
                    $already_voted = true;
                    break;
                }
            }
        }
        $current_poll_options = Option::where('poll_id', $current_poll->id)->get();

        return view('pages.page.home')->with('discountProducts',$discountProducts)->with('newProducts',$newProducts)->with('current_poll', $current_poll)->with('current_poll_options', $current_poll_options)->with('authenticated', Auth::user())->with('voted', $already_voted);;
    }

    public function search(Request $request){
        $products = Product::where('productTitle', 'ilike', '%' . $request->search . '%')->paginate(21)->withQueryString();
        if(count($products)<1)
            return view('pages.page.message')->with('message',"Nothing found.");
        else
            return view('pages.page.search')->with('products', $products)->with('search',$request->search);
    }

    public function show($id){
        return view('pages.page.product', [
            'product' => Product::findOrFail($id)
        ]);
    }

    public function index(Request $request){
        $category = null;
        if(isset($request['category'])){
            $category = $request['category'];
        }
   
        if($category){
            foreach(Product::all()->where('productType', $category) as $product){
                array_push($this->brands, $product->productBrand);
                if($product->productPrice >= $this->maxPrice){
                    $this->maxPrice = $product->productPrice;
                }
            }
            $this->brands = array_unique($this->brands);
            sort($this->brands);
            if(!isset($request['per-page'])){
                $request['per-page'] = 6;
            }

            if(!isset($request['order'])){
                $request['order'] = 'asc';
            }
            
            $products = Product::where('productType', $category);
           
 
            if($request["brands"]){
        
                $products = $products->whereIn('productBrand', $request["brands"]);
            }
            

            if($request['discount']){
                if($request['discount'] === 'true'){
                    $products = $products->where('productDiscount', true);
                }
            }

        
            
            if(!isset($request['priceFrom'])){
                $request['priceFrom'] = 0;
            }else{
                if(!is_numeric($request['priceFrom'])){
                    $request['priceFrom'] = 0;
                }
            }

            if(!isset($request['priceTo'])){
                $request['priceTo'] = $this->maxPrice;
            }else{
                if(!is_numeric($request['priceTo'])){
                    $request['priceTo'] = $this->maxPrice;
                }
            }


            
            $products = $products->where('productPrice', '>=', $request['priceFrom'])->where('productPrice', '<=', $request['priceTo']);
            session()->flashInput($request->input());
            #dd($products->get());
            return view('pages.page.category', ['products' => $products->orderBy('productPrice',$request['order'])->paginate($request['per-page'])->withQueryString(),
            'brands' => $this->brands,
            'maxPrice' => $this->maxPrice,
            'category' => $category]);
        }

    }

}