<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title">User</span>
                <hr>
                <div class="col s12 m7">
                    <div class="row">
                        <div class="col s4">
                            <img alt="" data-caption="<?php echo e($user->full_name); ?>" class="materialboxed" style="width: 100%; height: 100%; object-fit: cover" src="<?php echo e(asset('/profile/'.$user->image)); ?>">
                        </div>
                        <div class="col s8">
                            <div class="row">
                                <div class="col s6">
                                    <h6><i class="material-icons prefix">account_circle</i> <?php echo e($user->full_name); ?></h6>
                                </div>
                                <div class="col s6">
                                    <h6><i class="material-icons prefix">email</i> <?php echo e($user->email); ?></h6>
                                </div>
                                <div class="col s6">
                                    <h6>Postal Code: <?php echo e($user->postal_code); ?></h6>
                                </div>
                                <div class="col s6">
                                    <h6><i class="material-icons prefix">phone</i> <?php echo e($user->phone); ?></h6>
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
                        <p id="description"><?php echo e($order->note); ?></p>
                    </div>
                    <div class="col s12">
                        <h6>Change status</h6>
                        <select id="status_code" name="status_code">
                            <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($stat->id); ?>"
                                <?php if($order->status_code == $stat->id): ?>
                                    selected
                                <?php endif; ?>
                                ><?php echo e($stat->title); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
            </div>
            <?php
                $sum = 0;
            ?>
            <div class="card-content">
                <span class="card-title">Products</span>
                <div class="row"><hr>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                         $sum += $product->price * $product->quantity;
                        ?>

                    <div class="row">
                        <div class="col s12">
                            <h6><i class="material-icons prefix">title</i> Title: <?php echo e($product->title); ?></h6>
                        </div>
                        <div class="col s4">
                            <h6><i class="material-icons prefix">code</i> Code: <?php echo e($product->code); ?></h6>
                        </div>
                        <div class="col s3">
                            <h6><?php echo e($product->quantity); ?> x <?php echo e($product->price); ?><i class="material-icons tiny">euro_symbol</i></h6>
                        </div>
                        <div class="col s3">
                            <svg class="barcode"
                                 jsbarcode-format="auto"
                                 jsbarcode-value="<?php echo e($product->barcode); ?>"
                                 jsbarcode-textmargin="0"
                                 jsbarcode-height="70">
                            </svg>
                        </div>
                    </div>
                        <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <h5 class='right'>Total:
                        <?php
                            echo $sum;
                        ?>
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
            reverseGeocoding(<?php echo e($user->lat); ?>,<?php echo e($user->lng); ?>);

            $('#description_zoom').click(function () {
                if($('#description').hasClass('flow-text')) $('#description').removeClass('flow-text');
                else $('#description').addClass('flow-text');
            });

            $('#status_code').change(function () {
                var status = $(this).val();
                $.ajax({
                    url: "/api/order/<?php echo e($order->id); ?>/status/"+status,
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
            var lat = <?php echo e($user->lat); ?>;
            var lng = <?php echo e($user->lng); ?>;
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
            var apikey = '<?php echo e(env('REVERSE_API_OPENCAGEDATA')); ?>';
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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&callback=initMap" async defer></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/order/show.blade.php */ ?>