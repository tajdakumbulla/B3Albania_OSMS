@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title">User</span>
                <hr>
                <div class="col s12 m7">
                    <div class="row">
                        <div class="col s4">
                            <img alt="" data-caption="{{$user->full_name}}" class="materialboxed" style="width: 100%; height: 100%; object-fit: cover" src="{{asset('/profile/'.$user->image)}}">
                        </div>
                        <div class="col s8">
                            <div class="row">
                                <div class="col s6">
                                    <h6><i class="material-icons prefix">account_circle</i> {{$user->full_name}}</h6>
                                </div>
                                <div class="col s6">
                                    <h6><i class="material-icons prefix">email</i> {{$user->email}}</h6>
                                </div>
                                <div class="col s6">
                                    <h6>Postal Code: {{$user->postal_code}}</h6>
                                </div>
                                <div class="col s6">
                                    <h6><i class="material-icons prefix">phone</i> {{$user->phone}}</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col s12" style="padding: 10px;">
                            <hr>
                            <div class="col s12" id="map" style="width: 100%; height: 500px"> </div>
                        </div>
                        <div class="col s12">
                            <address><span style="font-size: medium" id="reverse_geocoding"></span></address>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-content">
                <span class="card-title">Order</span><hr>
                <div class="row" style="margin: 0">
                    <div class="col s12">
                        <h6><i style="cursor: pointer" id="description_zoom" class="material-icons">zoom_in</i> Note </h6>
                        <p id="description">{{$order->note}}</p>
                    </div>
                    <div class="col s12">
                        <h6>Change status</h6>
                        <select id="status_code" name="status_code">
                            @foreach($status as$stat)
                                <option value="{{$stat->id}}"
                                @if($order->status_code == $stat->id)
                                    selected
                                @endif
                                >{{$stat->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @php
                $sum = 0;
            @endphp
            <div class="card-content">
                <span class="card-title">Products</span>
                <div class="row"><hr>
                    @foreach($products as $product)
                        @php
                         $sum += $product->price * $product->quantity;
                        @endphp

                    <div class="row">
                        <div class="col s12">
                            <h6><i class="material-icons prefix">title</i> Title: {{$product->title}}</h6>
                        </div>
                        <div class="col s4">
                            <h6><i class="material-icons prefix">code</i> Code: {{$product->code}}</h6>
                        </div>
                        <div class="col s3">
                            <h6>{{$product->quantity}} x {{$product->price}}<i class="material-icons tiny">euro_symbol</i></h6>
                        </div>
                        <div class="col s3">
                            <svg class="barcode"
                                 jsbarcode-format="auto"
                                 jsbarcode-value="{{$product->barcode}}"
                                 jsbarcode-textmargin="0"
                                 jsbarcode-height="70">
                            </svg>
                        </div>
                    </div>
                        <hr>
                    @endforeach
                    <h5 class='right'>Total:
                        @php
                            echo $sum;
                        @endphp
                        <i class="material-icons tiny">euro_symbol</i></h5>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('select').formSelect();
            $('.slider').slider();
            $('.materialboxed').materialbox();
            JsBarcode(".barcode").init();
            reverseGeocoding({{$user->lat}},{{$user->lng}});

            $('#description_zoom').click(function () {
                if($('#description').hasClass('flow-text')) $('#description').removeClass('flow-text');
                else $('#description').addClass('flow-text');
            });

            $('#status_code').change(function () {
                var status = $(this).val();
                $.ajax({
                    url: "/api/order/{{$order->id}}/status/"+status,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Status changed successfully'});
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                });
            });
        });
        var map;
        var marker;
        var geocoder;
        function initMap() {
            var lat = {{$user->lat}};
            var lng = {{$user->lng}};
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: lat, lng: lng},
                zoom: 8
            });
            geocoder = new google.maps.Geocoder;

            var uluru = {lat: lat, lng: lng};
            marker = new google.maps.Marker({
                position: uluru,
                map: map,
                draggable: false
            });
        }
        function reverseGeocoding(latitude, longitude){
            var apikey = '{{env('REVERSE_API_OPENCAGEDATA')}}';
            var api_url = 'https://api.opencagedata.com/geocode/v1/json';
            var request_url = api_url + '?key=' +encodeURIComponent(apikey) + '&q=' + encodeURIComponent(latitude) + ',' + encodeURIComponent(longitude) + '&pretty=1&no_annotations=1';

            var request = new XMLHttpRequest();
            request.open('GET', request_url, true);
            request.onload = function() {
                if (request.status == 200){
                    var data = JSON.parse(request.responseText);
                    $('#reverse_geocoding').html(data.results[0].formatted);
                } else if (request.status <= 500) {
                    console.log("unable to geocode! Response code: " + request.status);
                } else console.log("server error");
            };
            request.onerror = function() {
                console.log("unable to connect to server");
            };
            request.send();
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}&callback=initMap" async defer></script>
@endsection

