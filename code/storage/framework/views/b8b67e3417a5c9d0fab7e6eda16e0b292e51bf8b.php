<?php $__env->startSection('content'); ?>

    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($message); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="container">
        <form method="post" action="<?php echo e(route('register')); ?>" id="user-update">
            <?php echo csrf_field(); ?>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="full_name" name="full_name" type="text" class="validate" required>
                            <label for="full_name">Full Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">email</i>
                            <input id="email" name="email" type="email" class="validate" required>
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input id="password" name="password" type="password" class="validate" required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="validate" required>
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                    </div><i class="material-icons prefix">location_on</i>
                    <div class="row">
                        <div id="map" style="width: 100%; height: 500px;"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="postal_code" name="postal_code" type="number" class="validate" required>
                            <label for="postal_code">Postal Code</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">phone</i>
                            <input id="phone" name="phone" type="number" class="validate" required>
                            <label for="phone">Phone</label>
                        </div>
                    </div>
                    <input type="hidden" name="lat" id="lat" value="">
                    <input type="hidden" name="lng" id="lng" value="">
                    <button id="update_user" class="btn waves-effect waves-light" type="button" name="action">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </form>
            </div>

        </form>
    </div>

    <script>

        $('#update_user').click(function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            $('#lat').val(lat);
            $('#lng').val(lng);
            M.toast({html: 'Updating'});
            setTimeout(function () {
                $('#user-update').submit();
            }, 1500);

        });
        var map;
        var marker;
        function initMap() {
            var lat = 41.3275;
            var lng = 19.8187;
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
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY')); ?>&callback=initMap" async defer></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/auth/register.blade.php */ ?>