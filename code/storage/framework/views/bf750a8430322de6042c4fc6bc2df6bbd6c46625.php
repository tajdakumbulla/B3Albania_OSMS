<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/materialize.js')); ?>" defer></script>

    <script src="<?php echo e(asset('js/jquery-3.3.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/JsBarcode.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/Chart.bundle.js')); ?>"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Styles -->
    <link href="<?php echo e(asset('css/materialize.css')); ?>" rel="stylesheet">
</head>
<body>
    <div id="app">
        <?php if(Auth::check()): ?>
            <?php if(Auth::user()->is_admin()): ?>
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="<?php echo e(route('admin.users')); ?>">Users</a></li>
                    <li><a href="<?php echo e(route('admin.products')); ?>">Products</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo e(route('admin.categories')); ?>">Categories</a></li>
                </ul>
                <div class="navbar">
                    <nav>
                        <div class="nav-wrapper">
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-logo center">
                                <img width="70px" height="70px" src="<?php echo e(asset("assets/B3.png")); ?>" alt="" class="circle responsive-img">
                            </a>
                            <ul class="left">
                                <!-- Dropdown Trigger -->
                                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Management<i class="material-icons right">arrow_drop_down</i></a></li>
                                <li><a href="<?php echo e(route('admin.orders')); ?>">Orders</a></li>
                                <li><a href="<?php echo e(route('admin.reports')); ?>">Reports</a></li>
                            </ul>
                            <ul class="right">
                                <li>
                                    <span id="logout-btn" style="cursor: pointer" >Logout<i class="material-icons right">exit_to_app</i></span>
                                    <form id="logout" method="post" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            <?php endif; ?>

            <?php if(Auth::user()->is_manager()): ?>
                    <div class="navbar">
                        <nav>
                            <div class="nav-wrapper">
                                <a href="<?php echo e(route('home')); ?>" class="brand-logo center">
                                    <img width="70px" height="70px" src="<?php echo e(asset("assets/B3.png")); ?>" alt="" class="circle responsive-img">
                                </a>
                                <ul class="left">
                                    <!-- Dropdown Trigger -->
                                    <li><a href="<?php echo e(route('admin.orders')); ?>">Orders</a></li>
                                    <li><a href="<?php echo e(route('manager.products.index')); ?>">Products</a></li>
                                </ul>
                                <ul class="right">
                                    <li>
                                        <span id="logout-btn" style="cursor: pointer" >Logout<i class="material-icons right">exit_to_app</i></span>
                                        <form id="logout" method="post" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
            <?php endif; ?>

            <?php if(Auth::user()->is_customer()): ?>
                    <div class="navbar">
                        <nav>
                            <div class="nav-wrapper">
                                <a href="<?php echo e(route('browse')); ?>" class="brand-logo center">
                                    <img width="70px" height="70px" src="<?php echo e(asset("assets/B3.png")); ?>" alt="" class="circle responsive-img">
                                </a>
                                <ul class="left hide-on-med-and-down">
                                    <li><i id="side_nav_toggle" style="cursor: pointer" class="material-icons right">menu</i></li>
                                </ul>

                                <ul class="right hide-on-med-and-down">
                                    <li>
                                        <span id="logout-btn" style="cursor: pointer" >Logout<i class="material-icons right">exit_to_app</i></span>
                                        <form id="logout" method="post" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                    <ul id="slide-out" class="sidenav">
                        <li><div class="user-view">
                                <div class="background">
                                    <img alt="" style="width: 100%;" src="<?php echo e(asset('/assets/sidenav_background.jpg')); ?>">
                                </div>
                                <a href="#user"><img class="circle" src="
                                <?php if(Auth::user()->image==''): ?>
                                    <?php echo e(asset('/assets/profile.png')); ?>

                                    <?php else: ?>
                                    <?php echo e(asset('/profile/'.Auth::user()->image)); ?>

                                        <?php endif; ?>
                                        "></a>
                                <a href="#name"><span class="white-text name"><?php echo e(Auth::user()->full_name); ?></span></a>
                                <a href="#email"><span class="white-text email"><?php echo e(Auth::user()->email); ?></span></a>
                            </div></li>
                        <li><a href="<?php echo e(route('browse')); ?>">Browse</a></li>
                        <li><div class="divider"></div></li>
                        <li><a class="subheader">Other</a></li>
                        <li><a href="<?php echo e(route('customer.cart')); ?>" class="waves-effect">My Cart</a></li>
                        <li><a href="<?php echo e(route('customer.profile')); ?>" class="waves-effect">My Profile</a></li>

                        <li><a href="<?php echo e(route('customer.orders.show')); ?>" class="waves-effect">My Orders</a></li>
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
            <?php endif; ?>



        <?php else: ?>
            <div class="navbar">
                <nav>
                    <div class="nav-wrapper">
                        <a href="<?php echo e(route('home')); ?>" class="brand-logo center">
                            <img width="70px" height="70px" src="<?php echo e(asset("assets/B3.png")); ?>" alt="" class="circle responsive-img">
                        </a>
                        <ul class="right">
                            <li><a href="<?php echo e(route('login')); ?>">login</a></li>
                            <li><a href="<?php echo e(route('register')); ?>">register</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        <?php endif; ?>


        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
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

<?php /* C:\Users\tajda\Desktop\software-project\resources\views/layouts/app.blade.php */ ?>