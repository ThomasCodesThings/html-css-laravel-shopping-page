@extends('layout.mainpage')

@section('content')
<div class="container mt-5">
        <div class="row row-cols-lg-3 row-cols-md-3 row-cols-sm-3 row-cols-1 align-items-center justify-content-center text-center">
            <article class="col d-flex justify-content-center text-center">
                <div class="thumbnail">
                    <a href="{{ url('/category/householdgoods') }}">

                    <img src="resources/household-200.jpg" class="img-fluid img-thumbnail">
                    <div class="caption">
                        <p class="text-center">Household goods</p>
                    </div>
                    </a>
                </div>
                </article>

            <article class="col d-flex justify-content-center text-center">
                <div class="thumbnail">
                    <a href="{{ url('/category/craft') }}">
                    <img src="resources/household-200.jpg" alt="Lights" class="img-fluid img-thumbnail">
                    <div class="caption">
                        <p class="text-center">Craft</p>
                    </div>
                    </a>
                </div>
            </article>

            <article class="col d-flex justify-content-center text-center">
                <div class="thumbnail">
                    <a href="{{ url('/category/toiletries') }}">
                    <img src="resources/household-200.jpg" alt="Lights" class="img-fluid img-thumbnail">
                    <div class="caption">
                        <p class="text-center">Toiletries</p>
                    </div>
                    </a>
                </div>
            </article>
        </div>
    </div>
    <div class="container-fluid text-center">
        <div class="poll">
        <h3 class="overflow-fix title">{{ $current_poll->question }}</h3>
        @if($voted)
        <p>Už ste zahlasovali!</p>
        @else
        <form method="POST" action="{{ url('polls/'.$current_poll->id.'/vote')}}">
            {{ csrf_field() }} 
            <input type="hidden" name="poll_id" value="{{ $current_poll->id }}">
            @foreach($current_poll_options as $option)
            <div class="col sm-auto" id="option_box">
                <input type="checkbox" name="option[]" value="{{ $option->option }}" onclick="onlyOne(this)">
                <label for="{{ $option }}"> {{ $option->option }} </label> <br>
            </div>
        @endforeach
        @if($authenticated)
        <button type="Submit" class="btn btn-dark btn-labeled text-center" type="Submit" onclick="this.form.submit()">Zahlasovať</button>
        @endif
        </form>
        @endif
        </div> 
    </div>

    <div class="container-fluid text-center">
        <div class="row d-flex justify-content-between align-items-start">
            <h1 class="overflow-fix title">New items</h1>
            <hr class="my-4">

                    @foreach($newProducts as $product)
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
        <button type="button" class="btn btn-dark btn-labeled text-center mb-5">Show more...</button>
    </div>

    <div class="container-fluid text-center">
        <div class="row d-flex justify-content-between">
            <h1 class="overflow-fix title">Discounts</h1>
            <hr class="my-4">
            @foreach($discountProducts as $product)
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
        <button type="button" class="btn btn-dark btn-labeled text-center mb-5">Show more...</button>
    </div>


@endsection