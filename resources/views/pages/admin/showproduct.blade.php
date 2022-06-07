@extends('layout.adminpage')

@section('content')
<h1>Product details: {{ $product->title }}</h1>
<div class="jumbotron">
	<div class="h5">Title</div>
    <p>
		{{ $product->productTitle }} 
  </p>

	<div class="h5">Price</div>
	<p>
		{{ $product->productPrice }}
	</p>

    <div class="h5">Brand</div>
    <p>
		{{ $product->productBrand }} 
    </p>

    <div class="h5">Amount</div>
    <p>
		{{ $product->productAmount }} 
    </p>

    <div class="h5">Discount</div>
    @if($product->productDiscount == true)
      <p><i class="fas fa-check"></i></p>
    @else
      <p><i class="fas fa-times"></i></p>
    @endif

    <div class="h5">Details</div>
    <p>
		{{ $product->productDetail }} 
    </p>

    <div class="h5">Type</div>
    <p>
		{{ $product->productType }} 
    </p>

    <div class="h5">Images</div>
  @foreach(json_decode($product->productImage, true) as $image)
      <img class="product border border-secondary mb-3" src="{{ asset('resources/'.$image) }}">
  @endforeach

    <div class="d-grid gap-2 newline">
    <a class="btn btn-warning mb-5  ms-0" href="{{ URL::to('products/' . $product->id . '/edit') }}">Edit</a>&nbsp;&nbsp;
    </div>
  @endsection