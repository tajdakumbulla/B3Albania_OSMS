<?php $__env->startSection('content'); ?>
    <span class="card-title">User</span>
    <hr>
    <table width="100%">
        <tr>
            <td>Name: <?php echo e($user->full_name); ?></td>
            <td>Postal Code: <?php echo e($user->postal_code); ?></td>
        </tr>
        <tr>
            <td>Email: <?php echo e($user->email); ?></td>
            <td><address><span style="font-size: medium" id="reverse_geocoding"><?php echo e($address); ?></span></address></td>
        </tr>
        <tr>
            <td>Phone: <?php echo e($user->phone); ?></td>
        </tr>
    </table><br><br>
    <span class="card-title">Order </span><hr>
    <span style="font-size: medium">Status: <?php echo e($status); ?></span><br>
    <span> Note: <?php echo e($order->note); ?></span>
    <br><br><br>
    <div class="container">
        <div class="card">
            <?php
                $sum = 0;
            ?>
            <span class="card-title">Products</span><hr>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $sum += $product->price * $product->quantity; ?>
                <span>Title: <?php echo e($product->title); ?></span><br>
                <span>Code: <?php echo e($product->code); ?></span><br>
                <span>Barcode: <?php echo e($product->barcode); ?></span><br>
                <span><?php echo e($product->quantity); ?> x <?php echo e($product->price); ?>&euro;</span>
                <hr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <h3 class='right'>Total:
                <?php
                    echo $sum;
                ?>
            </h3>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/report/order.blade.php */ ?>