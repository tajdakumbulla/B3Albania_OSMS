<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/materialize.js') }}" defer></script>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/JsBarcode.all.min.js') }}"></script>
    <script src="{{asset('js/Chart.bundle.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @if(Auth::check())
            @if(Auth::user()->is_admin())
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="{{route('admin.users')}}">Users</a></li>
                    <li><a href="{{route('admin.products')}}">Products</a></li>
                    <li class="divider"></li>
                    <li><a href="{{route('admin.categories')}}">Categories</a></li>
                </ul>
                <div class="navbar">
                    <nav>
                        <div class="nav-wrapper">
                            <a href="{{route('admin.dashboard')}}" class="brand-logo center">
                                <img width="70px" height="70px" src="{{asset("assets/B3.png")}}" alt="" class="circle responsive-img">
                            </a>
                            <ul class="left">
                                <!-- Dropdown Trigger -->
                                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Management<i class="material-icons right">arrow_drop_down</i></a></li>
                                <li><a href="{{route('admin.orders')}}">Orders</a></li>
                                <li><a href="{{route('admin.reports')}}">Reports</a></li>
                            </ul>
                            <ul class="right">
                                <li>
                                    <span id="logout-btn" style="cursor: pointer" >Logout<i class="material-icons right">exit_to_app</i></span>
                                    <form id="logout" method="post" action="{{route('logout')}}">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            @endif

            @if(Auth::user()->is_manager())
                    <div class="navbar">
                        <nav>
                            <div class="nav-wrapper">
                                <a href="{{route('home')}}" class="brand-logo center">
                                    <img width="70px" height="70px" src="{{asset("assets/B3.png")}}" alt="" class="circle responsive-img">
                                </a>
                                <ul class="left">
                                    <!-- Dropdown Trigger -->
                                    <li><a href="{{route('admin.orders')}}">Orders</a></li>
                                    <li><a href="{{route('manager.products.index')}}">Products</a></li>
                                </ul>
                                <ul class="right">
                                    <li>
                                        <span id="logout-btn" style="cursor: pointer" >Logout<i class="material-icons right">exit_to_app</i></span>
                                        <form id="logout" method="post" action="{{route('logout')}}">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
            @endif

            @if(Auth::user()->is_customer())
                    <div class="navbar">
                        <nav>
                            <div class="nav-wrapper">
                                <a href="{{route('browse')}}" class="brand-logo center">
                                    <img width="70px" height="70px" src="{{asset("assets/B3.png")}}" alt="" class="circle responsive-img">
                                </a>
                                <ul class="left hide-on-med-and-down">
                                    <li><i id="side_nav_toggle" style="cursor: pointer" class="material-icons right">menu</i></li>
                                </ul>

                                <ul class="right hide-on-med-and-down">
                                    <li>
                                        <span id="logout-btn" style="cursor: pointer" >Logout<i class="material-icons right">exit_to_app</i></span>
                                        <form id="logout" method="post" action="{{route('logout')}}">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <ul id="slide-out" class="sidenav">
                        <li><div class="user-view">
                                <div class="background">
                                    <img alt="" style="width: 100%;" src="{{asset('/assets/sidenav_background.jpg')}}">
                                </div>
                                <a href="#user"><img class="circle" src="
                                @if(Auth::user()->image=='')
                                    {{asset('/assets/profile.png')}}
                                    @else
                                    {{asset('/profile/'.Auth::user()->image)}}
                                        @endif
                                        "></a>
                                <a href="#name"><span class="white-text name">{{Auth::user()->full_name}}</span></a>
                                <a href="#email"><span class="white-text email">{{Auth::user()->email}}</span></a>
                            </div></li>
                        <li><a href="{{route('browse')}}">Browse</a></li>
                        <li><div class="divider"></div></li>
                        <li><a class="subheader">Other</a></li>
                        <li><a href="{{route('customer.cart')}}" class="waves-effect">My Cart</a></li>
                        <li><a href="{{route('customer.profile')}}" class="waves-effect">My Profile</a></li>

                        <li><a href="{{route('customer.orders.show')}}" class="waves-effect">My Orders</a></li>
                    </ul>
                <script>
                    $(document).ready(function () {
                        var sidenav = $('.sidenav').sidenav();
                        var sidenav_instance = M.Sidenav.getInstance(sidenav);

                        $('#side_nav_toggle').click(function () {
                            sidenav_instance.open();
                        });
                    });
                </script>
            @endif



        @else
            <div class="navbar">
                <nav>
                    <div class="nav-wrapper">
                        <a href="{{route('home')}}" class="brand-logo center">
                            <img width="70px" height="70px" src="{{asset("assets/B3.png")}}" alt="" class="circle responsive-img">
                        </a>
                        <ul class="right">
                            <li><a href="{{route('login')}}">login</a></li>
                            <li><a href="{{route('register')}}">register</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        @endif


        <main class="py-4">
            @yield('content')
        </main>

        <footer class="page-footer">
                <div class="row">
                    <div class="col s4">
                        <h6 class="white-text">Terms and Conditions</h6>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="/info/tos#tos_1">Introduction</a></li>
                            <li><a class="grey-text text-lighten-3" href="/info/tos#tos_3">Restrictions</a></li>
                            <li><a class="grey-text text-lighten-3" href="/info/tos#tos_4">Content</a></li>
                            <li><a class="grey-text text-lighten-3" href="/info/tos#tos_12">Jurisdiction</a></li>
                        </ul>
                    </div>
                    <div class="col s4">
                        <h6 class="white-text">Privacy Policy</h6>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="/info/pp#pp_1">Introduction</a></li>
                            <li><a class="grey-text text-lighten-3" href="/info/pp#pp_2">Log</a></li>
                            <li><a class="grey-text text-lighten-3" href="/info/pp#pp_3">Children</a></li>
                            <li><a class="grey-text text-lighten-3" href="/info/pp#pp_7">Consent</a></li>
                        </ul>
                    </div>
                    <div class="col s4">
                        <h6 class="white-text">Contact Us</h6>
                        <address>
                            Phone: xxx-xxx-xxxx <br>
                            Sheshi Skënderbeg, Tiranë 1000, Albania <br>
                            Email: be3albania@gmail.com
                        </address>
                        <h6 class="white-text">On Social Media</h6>
                        <a class="waves-effect waves-light btn-floating blue"><i class="fa fa-facebook"></i></a>
                        <a class="waves-effect waves-light btn-floating red"><i class="fa fa-instagram"></i></a>
                        <a class="waves-effect waves-light btn-floating" style="background-color: #55acee"><i class="fa fa-twitter"></i></a>
                    </div>
                </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2019 Copyright B3Albania
                    {{--<a class="grey-text text-lighten-4 right" href="#!">More Links</a>--}}
                </div>
            </div>
        </footer>
    </div>
</body>
<script>
    $(document).ready(function () {
        $(".dropdown-trigger").dropdown();
        $('#logout-btn').click(function () {
            $('#logout').submit();
        });
    });
</script>
</html>
