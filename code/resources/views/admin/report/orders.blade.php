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
    <h3 style="text-align: center">Orders</h3>
    <table>
        <thead>
        <tr>
            <td>User</td>
            <td>Status</td>
            <td>Created at</td>
            <td>Note</td>
        </tr>
        </thead>

        @foreach($orders as $order)
            <tr>
                <td>{{$order->full_name}}</td>
                <td>{{$order->title}}</td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->note}}</td>
            </tr>
        @endforeach
    </table>

@endsection
