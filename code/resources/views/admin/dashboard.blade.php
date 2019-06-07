@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <canvas id="order_chart_canvas" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card">
                <div class="card-content">
                    <canvas id="sales_chart_canvas" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card">
                <div class="card-content">
                    <canvas id="users_chart_canvas" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

        });

        var order_chart_canvas = document.getElementById('order_chart_canvas');
        var order_chart = new Chart(order_chart_canvas, {
            type: 'bar',
            data: {
                labels: [ @foreach($orders as $order) '{{$order->date}}', @endforeach ],
                datasets: [{
                    label: '# of Orders',
                    data: [ @foreach($orders as $order) {{$order->quantity}}, @endforeach ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        @php $count1 = 0; $count2 = 0; @endphp
        var sales_chart_canvas = document.getElementById('sales_chart_canvas');
        var sales_chart = new Chart(sales_chart_canvas, {
            type: 'bar',
            data: {
                labels: [@foreach($sales as $sale)
                    @php $count1++; @endphp
                    '{{$sale->date}}',
                    @if($count1 == 6) @break @endif
                    @endforeach],
                datasets: [{
                    label: '# of Product Sales',
                    data: [
                        @foreach($sales as $sale)
                        @php $count2++; @endphp
                        {{$sale->quantity}},
                        @if($count2 == 6) @break @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        @php $count1 = 0; $count2 = 0; @endphp
        var users_chart_canvas = document.getElementById('users_chart_canvas');
        var users_chart = new Chart(users_chart_canvas, {
            type: 'bar',
            data: {
                labels: [@foreach($users as $user)
                    @php $count1++; @endphp
                    '{{$user->month}}',
                    @if($count1 == 6) @break @endif
                    @endforeach],
                datasets: [{
                    label: '# of Users Joined',
                    data: [
                        @foreach($users as $user)
                        @php $count2++; @endphp
                        {{$user->number}},
                        @if($count2 == 6) @break @endif
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>


@endsection
