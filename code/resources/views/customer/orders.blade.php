@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">My Orders</span>
                {{--<a class="right btn waves-effect waves-light btn-small blue" href="{{route('admin.users.create')}}">Create<i class="material-icons right">add</i></a>--}}
                <table id="order-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>View</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#order-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('customer.orders.datatable')}}',
            columns: [
                {data: 'id'},
                {data: 'note'},
                {data: 'title'},
                {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection
