@extends('layout.adminpage')

@section('content')
<h1>Editácia úlohy</h1>
<hr>
<form action="{{url('coupons', [$coupon->id])}}" method="POST">
	<input type="hidden" name="_method" value="PUT">
    {{ csrf_field() }}

    <div class="form-group mb-3">
        <label for="title">Coupon code</label>
        <input type="text" class="form-control" id="coupon_code"  name="coupon_code" value="{{$coupon->coupon_code}}">
    </div>

    <div class="form-group mb-3">
        <label for="productBrand">Discount</label>
        <input type="text" class="form-control" id="Discount"  name="discount" value="{{$coupon->discount}}">
    </div>

    <div class="form-group mb-3">
        <label for="productPrice">Valid until</label>
        <input type="text" class="form-control" id="valid_until"  name="valid_until" placeholder="dd/mm/yyyy" value="{{$coupon->valid_until}}">
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
    <button type="submit" class="btn btn-primary">Change</button>
</form>
@endsection