@extends('layout.adminpage')
 
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
	<h1>Products</h1>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Product type</th>
                <th scope="col">Price</th>
                <th scope="col">Brand</th>
                <th scope="col">Amount</th>
                <th scope="col">Discount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($products as $product)
            <tr>
                <th scope="row">{{$product->id}}</th>
                <td><a href="/products/{{$product->id}}">{{$product->productTitle}}</a></td>
                <td>{{$product->productType}}</td>
                <td>{{$product->productPrice}}</td>
                <td>{{$product->productBrand}}</td>
                <td>{{$product->productAmount}}</td>
                @if($product->productDiscount == true)
                    <td><i class="fas fa-check"></i></td>
                @else
                    <td><i class="fas fa-times"></i></td>
                @endif
                <td>
                <form action="{{url('products', [$product->id])}}" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="submit" class="btn btn-danger" value="Delete"/>
                </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection