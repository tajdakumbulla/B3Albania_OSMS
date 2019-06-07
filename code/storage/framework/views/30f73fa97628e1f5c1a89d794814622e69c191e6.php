<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Order</span>
                <hr>
                <input type="hidden" id="order_id" value="<?php echo e($order->id); ?>">
                <div class="row">
                    <div class="row">
                        <div class="col s6">
                            <h6><i style="cursor: pointer" id="description_zoom" class="material-icons">zoom_in</i> Note </h6>
                            <p id="description"><?php echo e($order->note); ?></p>
                        </div>
                        <div class="col s6">
                            <h6>Status: <?php echo e($status->title); ?></h6>
                            <a class="remove_order btn tooltipped" data-position="bottom" data-tooltip="You can remove order if status received">Remove</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                $sum = 0;
            ?>
            <div class="card-content">
                <span class="card-title">Products</span>
                <div class="row">
                    <hr>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $sum += $product->price * $product->quantity;
                        ?>

                        <div class="row">
                            <div class="row">
                                <div class="col s12">
                                    <h6><i class="material-icons prefix">title</i> Title: <?php echo e($product->title); ?></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s4">
                                    <h6><i class="material-icons prefix">code</i> Code: <?php echo e($product->code); ?></h6>
                                </div>
                                <div class="col s4">
                                    <h6><i class="material-icons prefix">code</i> Barcode: <?php echo e($product->barcode); ?></h6>
                                </div>
                                <div class="col s4">
                                    <h6><?php echo e($product->quantity); ?> x <?php echo e($product->price); ?><i class="material-icons prefix tiny">euro</i></h6>
                                    
                                </div>
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
            $('.tooltipped').tooltip();

            $('#description_zoom').click(function () {
                if($('#description').hasClass('flow-text')) $('#description').removeClass('flow-text');
                else $('#description').addClass('flow-text');
            });

            $('.remove_order').click(function () {
                var order_id = $('#order_id').val();
                $.ajax({
                    url: "/customer/order/remove/"+order_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Order Deleted'});
                        } else if(statusCode.status==203) {
                            M.toast({html: 'Order can not be deleted'});
                        }
                    },
                });
            })
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/customer/order.blade.php */ ?>