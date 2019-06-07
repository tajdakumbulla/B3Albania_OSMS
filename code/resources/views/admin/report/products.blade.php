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
            <td>Quantity Left</td>
        </tr>
        </thead>
        @foreach($products as $product)
            <tr>
                <td>{{$product->id}}</td>
                <td>{{$product->title}}</td>
                <td>{{$product->barcode}}</td>
                <td>{{$product->code}}</td>
                <td>{{$product->price}}&euro;</td>
                <td>{{$product->in_stock}}</td>
            </tr>
        @endforeach
    </table>
@endsection
