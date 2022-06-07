@extends('layout.mainpage')

@section('content')
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ url('/category/'.$product->productType) }}">{{ ucfirst($product->productType) }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $product->productTitle }}</li>
  </ol>
</nav>

<div class="container mb-5" id="container">
        <div class="row" id="productDetails">
          <div class="col-sm-auto">
            <img id="showcase_img" class="mt-2" src="{{ asset('resources/'.json_decode($product->productImage, true)[0]) }}">
          </div>
          <div class="col-sm-auto" id="product-div">
              <h2> {{$product->productTitle }}</h2>

            <div><span>
              <p>
                <b>{{ $product->productPrice }} €</b>
              </p>
            </span></div>

          </div>
            <div class="row">
              
            <form action="{{ route('add-to-cart') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-sm-4 mt-2">
              <p>
                @if($product->productAmount > 5)
                In stock!
                @elseif($product->productAmount > 0 && $product->productAmount <= 5)
                Only {{ $product->productAmount }} left!
                @else
                Out of stock!
                @endif
              </p>
              @if($product->productAmount > 0)
              <div class="row row-cols-auto" id="value-box">
              <div class="col">
              <button type="button" class="control-btn btn-dark btn-sm" onclick="if(document.getElementById('number_input').value > 0){document.getElementById('number_input').value--}">-</button>
              </div>
                <div class="col">
              <input type="number" class="form-control-sm" id="number_input" name="amount" value="1" min="1">
              </div>
              <div class="col">
              <button type="button" class="control-btn btn-dark btn-sm" onclick="document.getElementById('number_input').value++">+</button>
              <!--<button type="button" class="control-btn" onclick="if(document.getElementById('number_input').value < {{ $product->productAmount }}){document.getElementById('number_input').value++}">+</button>-->
              </div>
              </div">
              @endif
            </div>
            </div>
            @if($product->productAmount > 0)
            <div class="row">  
              <div class="col">
                <input type="hidden" name="product" value="{{$product}}">
                <button type="submit" class="add_to_cart btn-sm btn-dark mt-1 mb-1">Add to cart</button>
              </div>
            </div>
            @endif
            </form>

          </div>
          </div>

          <div class="row row-cols-auto">
            <button type="button" class="btn-sm btn-dark mt-1 mb-1" id="desc-brn" onclick="document.getElementById('product-galery').style.display = 'none'; document.getElementById('product-description').style.display = 'block';">Description</button>
            <button type="button" class="btn-sm btn-dark mt-1 mb-1" id="galery-btn" onclick="document.getElementById('product-description').style.display = 'none'; document.getElementById('product-galery').style.display = 'block';">Galery</button>
          </div>
         <div class="row">
           <hr>
          <div class="row" id="product-galery">
          @if(count(json_decode($product->productImage, true)) > 0)
            <div class="galery">
              <div class="modal" id="modal">
              <img class="modal-content" id="modal_img">
              <span class="close" id="close">&times;</span> 
              </div> 
              <div class="col-sm-auto"> 
              @foreach(json_decode($product->productImage, true) as $image)
              <img src="{{ asset('resources/'.$image) }}" class="mt-1 mb-1" id="product_img" onclick="display(this)">
              @endforeach
              </div>
              @endif
          </div>
          </div>
          <div class="row" id="product-description">
          <p>
          {{ $product->productdetail }}
          </p>
          </div>
          </div>
</div>
@endsection