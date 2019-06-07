@extends('layouts.report')

@section('content')
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <h3 style="text-align: center">Products</h3>
    <table style="width: 100%; border: black">
        <thead>
        <tr>
            <td>Id</td>
            <td>Title</td>
            <td>Barcode</td>
            <td>Code</td>
            <td>Price</td>
            <td>Quantity Sold</td>
            <td>Total Earnings</td>
        </tr>
        </thead>
        @php $sum = 0.0; $sumQuantity=0.0; @endphp
        @foreach($products as $product)
            @php $sum += $product->totalSum; $sumQuantity += $product->totalQuantity; @endphp
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->title}}</td>
                <td>{{$product->barcode}}</td>
                <td>{{$product->code}}</td>
                <td>{{$product->price}}&euro;</td>
                <td>{{$product->totalQuantity}} units</td>
                <td>{{$product->totalSum}}&euro;</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total:{{$sumQuantity}} units</td>
            <td>Total:{{$sum}}&euro;</td>
        </tr>
    </table>
@endsection
