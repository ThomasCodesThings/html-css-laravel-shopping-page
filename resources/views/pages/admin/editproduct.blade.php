@extends('layout.adminpage')

@section('content')
<h1>Edit product</h1>
<hr>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('products', [$product->id])}}" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_method" value="PUT">
    {{ csrf_field() }}

    <div class="form-group mb-3">
        <label for="title">Product title</label>
        <input type="text" value="{{$product->productTitle}}" class="form-control" id="productTitle"  name="productTitle">
    </div>

    <div class="form-group mb-3">
        <label for="productBrand">Brand</label>
        <input type="text" value="{{$product->productBrand}}" class="form-control" id="productBrand"  name="productBrand">
    </div>

    <div class="form-group mb-3">
        <label for="productPrice">Price</label>
        <input type="text" value="{{$product->productPrice}}" class="form-control" id="productPrice"  name="productPrice">
    </div>

    <div class="form-group mb-3">
        <label for="productAmount">Amount</label>
        <input type="text" value="{{$product->productAmount}}" class="form-control" id="productAmount"  name="productAmount">
    </div>

    <div class="form-check mb-3">
        @if($product->productDiscount == false)
            <input class="form-check-input" type="checkbox" id="productDiscount" name="productDiscount">
            <label class="form-check-label" for="productDiscount">Discount item</label>
        @else
            <input class="form-check-input" type="checkbox" id="productDiscount" name="productDiscount" checked>
            <label class="form-check-label" for="productDiscount">Discount item</label>
        @endif
    </div>

    <div class="form-group mb-3">
        <label for="title">Details</label>
        <input type="textarea" value="{{$product->productDetail}}" class="form-control" id="productDetail"  name="productDetail">
    </div>

    <div class="form-group form-group-sm mb-3">
        <label  for="productType">Product type</label>
        <select class="form-control" name="productType" id="productType" value="{{$product->productType}}">
            <option value="householdgoods">Household goods</option>
            <option value="toiletries">Toiletries</option>
            <option value="craft">Craft</option>
        </select>
    </div>

    <label for="img">Images</label>
    <div class="input-group hdtuto control-group lst" id="img">
        <input type="file" name="filenames[]" class="myfrm form-control mb-3" multiple>
    </div>
    <button type="submit" class="btn btn-dark mb-3">Change</button>
</form>

<div class="container-fluid text-start">
        <div class="row d-flex justify-content-start">
        @foreach(json_decode($product->productImage, true) as $image)
                <div class="col-auto">
                    <img class="product border border-secondary mb-3" src="{{ asset('resources/'.$image) }}">
                    <form action="{{ route('delete', ['product' => $product, 'image'=> $image])}}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger mb-3" value="Remove"/>
                    </form>
                </div>
        @endforeach
        </div>
</div>
@endsection