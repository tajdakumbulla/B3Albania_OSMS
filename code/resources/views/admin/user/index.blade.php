@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">User Management</span>
                <a class="right btn waves-effect waves-light btn-small blue" href="{{route('admin.users.create')}}">Create<i class="material-icons right">add</i></a>
                <table id="user-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>User Level</th>
                        <th>Registered</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#user-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{route('datatable.users')}}',
            columns: [
                {data: 'id'},
                {data: 'full_name'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'user_level'},
                {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
@endsection

