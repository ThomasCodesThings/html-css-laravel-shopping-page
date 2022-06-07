<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all()->sortBy('id');
        return view('pages.admin.viewproducts',compact('products',$products));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.createproduct');
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
            'productTitle' => 'required|min:3',
            'productPrice' => 'required',
            'filenames' => 'required',
            'filenames.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $files = [];
        if($request->hasfile('filenames'))
         {
            foreach($request->file('filenames') as $file)
            {
                do{
                    $name = time().rand(1,100).'.'.$file->extension();
                }while (file_exists(public_path('resources/'.$name)));

                $file->move(public_path('resources'), $name);  
                $files[] = $name;  
            }
         }

        $product = Product::create(['productTitle' => $request->productTitle,
        'productImage' => json_encode($files), 
        'productType' => $request->productType,
        'productBrand' => $request->productBrand,
        'productAmount' => $request->productAmount,
        'productdetail' => $request->productDetail,
        'productDiscount' =>  ($request->productDiscount == "checked") ? true : false,
        'productPrice' => $request->productPrice]);
          
        /*redirect na funkciu show*/
        return redirect('/products/'.$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('pages.admin.showproduct',compact('product', $product));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.admin.editproduct',compact('product',$product));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'productTitle' => 'required|min:3',
            'productType' => 'required',
            'productPrice' => 'required',
            'productBrand' => 'required',
            'productAmount' => 'required',
        ]);  

        if($request->hasfile('filenames'))
         {
            $images = json_decode($product->productImage, true);
            foreach($request->file('filenames') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('resources'), $name);  
                array_push($images, $name);  
            }
            $product->productImage = json_encode($images);
         }
             
        $product->productTitle = $request->productTitle ;
        $product->productType = $request->productType ;
        $product->productPrice = $request->productPrice ;
        $product->productBrand = $request->productBrand ;
        $product->productAmount = $request->productAmount ;
        if(isset($request->productDetail))
            $product->productdetail = $request->productDetail ;
        $product->productDiscount = ($request->productDiscount == null) ? false : true;
        $product->save();
        $request->session()->flash('message', 'Data succesfully changed.');
          
        return redirect('/products/'.$product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Product $product)
    {
        foreach(json_decode($product->productImage, true) as $image){
            unlink("resources/".$image);
        }
        $product->delete();
        $request->session()->flash('message', 'Product deleted succesfully.');
        return redirect('products');
    }

    public function deleteImage(Request $request, Product $product, String $image)
    {
        unlink("resources/".$image);
        $files = json_decode($product->productImage, true);
        if (($key = array_search($image, $files)) !== false) {
            unset($files[$key]);
            $product->productImage = json_encode($files);
            $product->save();
            $request->session()->flash('message', 'Image deleted succesfully.');
        }
        else
            $request->session()->flash('message', 'Image does not exist.');
        return view('pages.admin.editproduct',compact('product', $product));
    }
}
