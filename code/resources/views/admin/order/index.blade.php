@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Order Management</span>
                <table id="order-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Edit</th>
                        <th>Print</th>
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
            ajax: '{{route('datatable.orders')}}',
            @if(Auth::user()->is_manager())
            "oSearch": {"sSearch": "{{\Carbon\Carbon::now()->toDateString()}}"},
            @endif
            "order": [[ 4, "desc" ]],
            columns: [
                {data: 'id'},
                {data: 'full_name'},
                {data: 'note'},
                {data: 'status'},
                {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
                {data: 'action_2', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection

