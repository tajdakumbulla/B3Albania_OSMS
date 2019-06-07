@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">Update User</span>
                <form method="post" id="user-update" action="{{route('users.update', ['id'=>$user->id])}}">
                    @csrf
                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="full_name" name="full_name" type="text" class="validate" required value="{{$user->full_name}}">
                                <label for="full_name">Full Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input id="email" name="email" type="email" class="validate" required value="{{$user->email}}">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="postal_code" name="postal_code" type="text" class="validate" required value="{{$user->postal_code}}">
                                <label for="postal_code">Postal Code</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phone</i>
                                <input id="phone" name="phone" type="text" class="validate" required value="{{$user->phone}}">
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <select name="user_level">
                                <option value="" disabled selected>Choose User Level</option>
                                <option value="1" @if($user->user_level==1) selected @endif >Customer</option>
                                <option value="2" @if($user->user_level==2) selected @endif >Manager</option>
                                <option value="3" @if($user->user_level==3) selected @endif >Admin</option>
                            </select>
                            <label>User Level</label>
                        </div>
                        <button id="update-user" class="btn waves-effect waves-light btn-small" type="submit" name="action">Update
                            <i class="material-icons right">update</i>
                        </button>
                        <button id="delete-user" class="btn waves-effect waves-light btn-small red" type="button" name="action">Delete
                            <i class="material-icons right">delete_forever</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        //TODO: remove git
        $(document).ready(function(){
            $('select').formSelect();
        });
        $('#delete-user').click(function () {
            if(confirm('Confirm delete')){
                $.ajax({
                    url: "{{route('users.destroy', ['id'=>$user->id])}}",
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Deleted Successfully! Redirecting...'});
                            setTimeout(function () {
                                window.location.href = '{{route('admin.users')}}'
                            }, 1500)
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    }
                });
            }
        });
    </script>
@endsection

