@extends('layout.adminpage')
 
@section('content')
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
	<h1>Coupons</h1>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Coupon code</th>
                <th scope="col">Discount</th>
                <th scope="col">Valid until</th>
            </tr>
        </thead>
        <tbody>
        @foreach($coupons as $coupon)
            <tr>
                <th scope="row">{{$coupon->id}}</th>
                <td><a href="/coupons/{{$coupon->id}}">{{$coupon->coupon_code}}</a></td>
                <td>{{$coupon->discount}}</td>
                <td>{{$coupon->valid_until}}</td>
                <td>
                        <form action="{{url('coupons', [$coupon->id])}}" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger" value="Delete"/>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection