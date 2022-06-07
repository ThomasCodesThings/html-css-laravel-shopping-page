@extends('layout.adminpage')

@section('content')
<h1>Coupon details </h1>
<div class="jumbotron">
	<div class="h5">Coupon code</div>
    <p>
		{{ $coupon->coupon_code }} 
    </p>

    <div class="h5">Discount</div>
    <p>
		{{ $coupon->discount }} 
    </p>

	<div class="h5">Valid until</div>
	<p>
		{{ $coupon->valid_until }}
	</p>

    <div class="d-grid gap-2 newline">
    <a class="btn btn-warning ms-0" href="{{ URL::to('coupons/' . $coupon->id . '/edit') }}">Edit</a>&nbsp;&nbsp;
    </div>
</div>
@endsection