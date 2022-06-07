@extends('layout.mainpage')
@section('content')
<h1 class="overflow-fix title">Results for "{{ $search }}" </h1>
<hr class="my-4">

<div class="row d-flex justify-content-between overflow-fix">
@foreach($products as $product)
<article class="product text-center col-auto mb-3">
                                <a class="d-block" href="{{ url('/'.$product->id) }}">
                                <img class="product border border-secondary" src="{{ asset('resources/'.json_decode($product->productImage, true)[0]) }}">
                                <p class="product">{{$product->productTitle}}</p>
                            </a>
                            <div class="container">
                                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-1 no-gutters">
                                    <div class="col">
                                        <p class="product text-center"><data value="50">{{$product->productPrice}}</data>$</p>
                                    </div>
                                    <div class="col">
                                    <form action="{{ route('add-to-cart') }}" method="post">
                                  @csrf
                                    <input type="hidden" name="product" value="{{$product}}">
                                    <input type="hidden" name="amount" value="1">
                                    <a href="javascript:;" onclick="parentNode.submit();" class="product text-center">Buy</a> 
                                    </form> 
                                    </div>
                                </div>
                            </div>
                        </article>
@endforeach
</div>
    <div class="fix-pagination-a">
        {{ $products->links()}}
    </div>
@endsection