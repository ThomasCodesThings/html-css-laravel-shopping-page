@extends('layout.mainpage')
@section('content')
      <h1>Cart</h1>
      
        @if(Session::get('message'))
        {{ Session::get('message') }}
        @endif
      <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 overflow-fix">
          <div class="col-lg-8 col-md-8 col-sm-12 col-12 mt-3 mb-3 overflow-fix" id="cart-items-col">
              @if($cart)
              @foreach($cart as $cart_item)
                <div class="col-sm-auto mb-2 border me-2" id="cart-row">
                        <div class="row row-cols-xl-5 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-2 justify-content-end">
                        
                            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-4 col-4 mt-2 mb-2 ps-0 pe-0">
                                <a href="{{ url('/'.json_decode(json_encode($cart_item['product']), true)['id']) }}"><img id="showcase_img_small" src="{{ asset('resources/'.json_decode((json_decode(json_encode($cart_item['product']), true)['productImage']), true)[0] ) }}"></a>
                            </div>   

                            <div class="col-xl-3 col-lg-5 col-md-7 col-sm-8 col-8 col-7 ps-0 pe-0">
                                <h5 class="mt-2"><a href="{{ url('/'.json_decode(json_encode($cart_item['product']), true)['id']) }}">{{ json_decode(json_encode($cart_item['product']), true)['productTitle'] }}</a></h5>
                            </div>

                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-5 ps-0 pe-0">
                                <form action="{{ route('update-cart') }}" method="post" id="change-form">
                                @csrf
                                    <input type="hidden" name="productID" value="{{ json_decode(json_encode($cart_item['product']), true)['id'] }}">
                                    <input type="hidden" name="oldAmount" value="{{ json_decode(json_encode($cart_item['quantity']), true) }}">
                                    <div class="row row-cols-auto" id="value-box">
                                    <div class="col">
                                        <button type="button" class="decrement-btn btn-sm btn-dark mt-2" id="decrement-btn">-</button>
                                    </div>
                                    <div class="col">
                                    <input type="number" class="cart-input form-control-sm mt-2" id="cart_value_input" name="newAmount" value="{{ json_decode(json_encode($cart_item['quantity']), true) }}" onchange="this.form.submit()"> 
                                    </div>
                                    <div class="col">
                                        <button type="button" class="increment-btn btn-sm btn-dark mt-2" id="increment-btn">+</button>
                                    </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-6 pe-0">
                                <p class="mt-2">
                                    <b>
                                    {{ json_decode(json_encode($cart_item['product']), true)['productPrice'] * json_decode(json_encode($cart_item['quantity']), true) }}€
                                    </b> ({{ json_decode(json_encode($cart_item['product']), true)['productPrice'] }} x {{ json_decode(json_encode($cart_item['quantity']), true) }}x)
                                </p>
                            </div>


                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 ps-0 pe-0">
                                <form action="{{ route('delete-product-from-cart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="productID" value="{{ json_decode(json_encode($cart_item['product']), true)['id'] }}">
                                        <button class="x-btn btn-sm btn-dark mb-2 mt-2">x</button>
                                    </form>
                            </div>
        
                            </div>
                        </div>
                @endforeach
                @else
                <h4 class="margin_add">I´m so empty :(((</h4>
                @endif
          </div>

          @if($cart)
          <div class="col-lg-4 col-md-4 col-sm-12 col-12 overflow-fix border" id="checkout">
              <h2>Total</h2>
              <hr>
  
              <div class="row">
                  <div class="col-auto">
                       Price
                  </div>
                  <div class="col-auto">
                  <?php
                  $sum = 0;
                  foreach($cart as $cart_item){
                      $sum += (json_decode(json_encode($cart_item['product']), true)['productPrice'] * json_decode(json_encode($cart_item['quantity']), true));
                  }
                  ?>
                  {{ $sum }} €
                  </div>
                  
                </div>
  
              <form action='/checkouts/create' method="get">
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label"><b>I have a coupon code</b></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" name="couponCode" placeholder="Enter coupon">
                            </div>
                    </div>
                        
                    <div class="row">
                        <input type="hidden" name="cart">
                        <button class="btn btn-dark" type="submit">Go to checkout</button>
                    </div>
                </form>
          </div>
          @endif
        </div>
      </div>
    </div>

@endsection