@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s6">
            <div class="card">
                <form id="report" method="post" action="{{route('admin.reports.orders')}}">
                    @csrf
                    <div class="card-content">
                        <div class="card-title">Orders</div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="from_date" name="from_date" type="text" class="datepicker">
                                <label for="from_date">From Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="to_date" name="to_date" type="text" class="datepicker">
                                <label for="to_date">To Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <select id="status_code" name="status_code">
                                    <option></option>
                                    @foreach($status as $stat)
                                        <option value="{{$stat->id}}">
                                            {{$stat->title}}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Status</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Make
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s6">
            <div class="card">
                <form id="report" method="post" action="{{route('admin.reports.sales')}}">
                    @csrf
                    <div class="card-content">
                        <div class="card-title">Sales</div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="from_date_sales" name="from_date_sales" type="text" class="datepicker">
                                <label for="from_date_sales">From Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="to_date_sales" name="to_date_sales" type="text" class="datepicker">
                                <label for="to_date_sales">To Date</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Make
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s6">
            <div class="card">
                <form id="report" method="post" action="{{route('admin.reports.products')}}">
                    @csrf
                    <div class="card-content">
                        <div class="card-title">Products</div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="min_quantity" name="min_quantity" required min="0" type="number" class="validate" value="0">
                                <label for="min_quantity">Min Quantity</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="max_quantity" name="max_quantity" required min="0" type="number" class="validate" value="0">
                                <label for="max_quantity">Max Quantity</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Make
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker({
                'format' : 'yyyy-mm-dd'
            });
            $('select').formSelect();
        });
    </script>
@endsection
