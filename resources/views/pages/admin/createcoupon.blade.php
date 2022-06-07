@extends('layout.adminpage')

@section('content')
<h1>Add new coupon</h1>
<hr>
<form action="/coupons" method="post">
    {{ csrf_field() }}
    <div class="form-group mb-3">
        <label for="title">Coupon code</label>
        <input type="text" class="form-control" id="coupon_code"  name="coupon_code">
    </div>

    <div class="form-group mb-3">
        <label for="productBrand">Discount</label>
        <input type="text" class="form-control" id="Discount"  name="discount">
    </div>

    <div class="form-group mb-3">
        <label for="productPrice">Valid until</label>
        <input type="text" class="form-control" id="valid_until"  name="valid_until" placeholder="dd/mm/yyyy">
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection 