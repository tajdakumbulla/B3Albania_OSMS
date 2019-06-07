@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">Update Profile</span>
                <form method="post" id="user-update" action="{{route('customer.profile.update', ['id' => $user->id])}}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="row">
                            <div class="input-field col s12">
                                <img width="100%" class="materialboxed center-align" src="
                                @if(Auth::user()->image=='')
                                    {{asset('/assets/profile.png')}}
                                    @else
                                    {{asset('/profile/'.Auth::user()->image)}}
                                    @endif
                                    ">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>File</span>
                                        <input type="file" name="image">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        </div><i class="material-icons prefix">location_on</i>
                        <div class="row">
                            <div id="map" style="width: 100%; height: 500px;"></div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="postal_code" name="postal_code" type="number" class="validate" required value="{{$user->postal_code}}">
                                <label for="postal_code">Postal Code</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phone</i>
                                <input id="phone" name="phone" type="number" class="validate" required value="{{$user->phone}}">
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <input type="hidden" name="lat" id="lat" value="{{$user->lat}}">
                        <input type="hidden" name="lng" id="lng" value="{{$user->lng}}">
                        <button id="update_user" class="btn waves-effect waves-light btn-small" type="button" name="action">Update
                            <i class="material-icons right">update</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $('.materialboxed').materialbox();

            $('#update_user').click(function () {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                $('#lat').val(lat);
                $('#lng').val(lng);
                console.log(lat + lng);
                M.toast({html: 'Updating'});
                setTimeout(function () {
                    $('#user-update').submit();
                }, 500);

            });
        });
        var map;
        var marker;
        function initMap() {
            var lat = {{$user->lat}};
            var lng = {{$user->lng}};
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lng},
                zoom: 8
            });

            var uluru = {lat: lat, lng: lng};
            marker = new google.maps.Marker({
                position: uluru,
                map: map,
                draggable: true
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap" async defer></script>


@endsection

