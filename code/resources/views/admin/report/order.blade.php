@extends('layouts.report')

@section('content')
    <span class="card-title">User</span>
    <hr>
    <table width="100%">
        <tr>
            <td>Name: {{$user->full_name}}</td>
            <td>Postal Code: {{$user->postal_code}}</td>
        </tr>
        <tr>
            <td>Email: {{$user->email}}</td>
            <td><address><span style="font-size: medium" id="reverse_geocoding">{{$address}}</span></address></td>
        </tr>
        <tr>
            <td>Phone: {{$user->phone}}</td>
        </tr>
    </table><br><br>
    <span class="card-title">Order </span><hr>
    <span style="font-size: medium">Status: {{$status}}</span><br>
    <span> Note: {{$order->note}}</span>
    <br><br><br>
    <div class="container">
        <div class="card">
            @php
                $sum = 0;
            @endphp
            <span class="card-title">Products</span><hr>
            @foreach($products as $product)
                @php $sum += $product->price * $product->quantity; @endphp
                <span>Title: {{$product->title}}</span><br>
                <span>Code: {{$product->code}}</span><br>
                <span>Barcode: {{$product->barcode}}</span><br>
                <span>{{$product->quantity}} x {{$product->price}}&euro;</span>
                <hr>
            @endforeach
            <h3 class='right'>Total:
                @php
                    echo $sum;
                @endphp
            </h3>
        </div>
    </div>
@endsection

