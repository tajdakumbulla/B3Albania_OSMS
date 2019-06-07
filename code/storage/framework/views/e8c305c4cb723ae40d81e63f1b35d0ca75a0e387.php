<?php $__env->startSection('content'); ?>
<div class="container">
    <?php if(isset($msg)): ?>
        <blockquote>
            <?php echo e($msg); ?>

        </blockquote>
    <?php endif; ?>
    <div class="card">
        <div class="card-content">
        <form method="post" id="cart_order" action="<?php echo e(route('cart.order')); ?>">
            <?php echo csrf_field(); ?>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <input class="products" type="hidden" name="product_id[]" value="<?php echo e($product->id); ?>">
                <input id="stock_<?php echo e($product->id); ?>" type="hidden" value="<?php echo e($product->in_stock); ?>">
                <input id="title_<?php echo e($product->id); ?>" type="hidden" value="<?php echo e($product->title); ?>">
                <input id="price_<?php echo e($product->id); ?>" type="hidden" value="<?php echo e($product->price); ?>">
                <div id="product_div_<?php echo e($product->id); ?>" style="height: 40rem">
                    <div class="col s6">
                        <div id="images">
                            <?php if(isset($product->images)): ?>
                                <div class="slider">
                                    <ul id="product_images" class="slides">
                                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><img class="materialboxed" alt="" src="<?php echo e(asset('/img/'.$image->url)); ?>"></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col s7">
                                <h5><?php echo e($product->title); ?></h5>
                                <p><?php echo e($product->description); ?></p>
                            </div>
                            <div class="col s1">
                                <h5><?php echo e($product->price); ?><i class="tiny material-icons">euro_symbol</i></h5>
                            </div>
                            <div class="input-field col s3">
                                <input class="quantity" min="1" id="quantity_<?php echo e($product->id); ?>" value="1" name="quantity[]" type="number" class="validate">
                                <label class="active" for="first_name2">Quantity</label>
                            </div>
                            <a class="btn-floating btn-flat white waves-effect waves-red waves-circle">
                                <i product_id="<?php echo e($product->id); ?>" style="color: red;" class="remove_cart material-icons">delete</i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="note" id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">Note</label>
                </div>
                <div class="col s6">
                    <h5 id="sum"></h5>
                </div>
                <div class="input-field col s6">
                    <button id="submit_order" class="btn waves-effect waves-light right" type="submit" name="action">Make Order
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
            <input type="hidden" id="verified" value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->verified); ?>">
        </form>
        </div>
    </div>
</div>


    <script>
        $(document).ready(function(){
            $('.slider').slider();
            $('.materialboxed').materialbox();
            $('#submit_order').addClass('disabled');
            calculate();

            $('.quantity').change(function () {
                calculate();
            });

            function calculate() {
                var sum = 0;
                $('.products').each( function () {
                    if($('#verified').val()==0){
                        M.toast({html: 'Please verify your e-mail'});
                        $('#submit_order').addClass('disabled');
                        return false;
                    }
                    var id = $(this).val();
                    var stock = parseInt($('#stock_'+id).val());
                    var quantity = parseInt($('#quantity_'+id).val());
                    if(quantity > stock || stock<=0){
                        var name = $('#title_'+id).val();
                        M.toast({html: 'Product ' + name + ' is out of stock. You can try to change quantity or remove item from cart!'});
                        $('#submit_order').addClass('disabled');
                        return false;
                    }
                    $('#submit_order').removeClass('disabled');
                    sum += quantity * parseFloat($('#price_'+id).val());
                    $('#sum').html('Total: '+sum + '<i class="material-icons tiny">euro_symbol</i>');
                });
            }

            $('.remove_cart').click(function () {
                var product_id = $(this).attr('product_id');
                $.ajax({
                    url: "/api/customer/<?php echo e(\Illuminate\Support\Facades\Auth::user()->id); ?>/cart/remove/"+product_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(result);
                        if(statusCode.status==201){
                            M.toast({html: 'Item removed from cart'});
                            $('#product_div_'+product_id).remove();
                        }
                    },
                });
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/customer/cart.blade.php */ ?>