<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="container">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="card-title">Images</div>
                        <div class="col s12">
                            <div id="images">
                                <div class="slider">
                                    <ul id="product_images" class="slides">
                                        <?php if(isset($product_images)): ?>
                                            <?php $__currentLoopData = $product_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li id="<?php echo e($image->url); ?>">
                                                    <img class="materialboxed" src="<?php echo e(asset('/img/'.$image->url)); ?>">
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-title">Information</div>
                    <div class="row">
                        <div class="row">
                            <div class="col s12">
                                <h6>Title: <?php echo e($product->title); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <h6>Code: <?php echo e($product->code); ?></h6>
                            </div>
                            <div class="col s6">
                                <h6>Price: <?php echo e($product->price); ?><i class="material-icons tiny">euro_symbol</i> </h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <h6><i style="cursor: pointer" id="description_zoom" class="material-icons">zoom_in</i> Description </h6>
                                <p id="description"><?php echo e($product->description); ?></p>
                            </div>
                        </div>
                        <div id="show-categories" class="col s12">
                            <div class="card-title">Categories</div>
                            <?php if(isset($product_categories)): ?>
                                <?php $__currentLoopData = $product_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chip">
                                        <?php echo e($product_category->title); ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="col s12">
                            <div class="card-title">Actions</div>
                            <a href="<?php echo e(route('customer.order', ['id' => $product->id])); ?>" class="btn waves-effect waves-light" type="submit" name="action">Order
                                <i class="material-icons right">send</i>
                            </a>
                            <button product_id="<?php echo e($product->id); ?>" class="add_cart btn waves-effect waves-light" type="submit" name="action">Add to Cart
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="card-title">Make Review</div>
                                <form id="make_review" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                    <div class="input-field col s6">
                                        <textarea name="description" id="textarea1" class="materialize-textarea" required></textarea>
                                        <label for="textarea1">Description</label>
                                    </div>
                                    <div class="input-field col s6">
                                        <p>Rating</p>
                                        <p class="range-field">
                                            <input name="rating" type="range" id="test5" min="0" max="5" />
                                        </p>
                                    </div>
                                    <div class="col s12">
                                        <button product_id="<?php echo e($product->id); ?>" class="send_review btn waves-effect waves-light" type="button" name="action">Send
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <div class="card-content">Reviews</div>
                                <ul class="collection">
                                <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li id="review_user_<?php echo e($review->user->id); ?>" class="collection-item avatar">
                                        <img class="circle" src="
                                <?php if($review->user->image==''): ?>
                                        <?php echo e(asset('/assets/profile.png')); ?>

                                        <?php else: ?>
                                        <?php echo e(asset('/profile/'.$review->user->image)); ?>

                                        <?php endif; ?>
                                            ">
                                        <span class="title"><?php echo e($review->user->full_name); ?></span>
                                        <p><?php echo e($review->description); ?></p>
                                        <a class="secondary-content">Rating: <?php echo e($review->rating); ?>/5</a>
                                        <?php if($review->user_id == \Illuminate\Support\Facades\Auth::user()->id): ?>
                                        <a product_id="<?php echo e($product->id); ?>" class="remove_review right btn-flat waves-effect waves-light btn-small">remove</a>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12" style="align-content: center">
                            <ul class="pagination" style="align-content: center">
                                <?php if($pages != 1): ?>
                                    <?php if($page == 1): ?>
                                        <li class="disabled"><i class="material-icons">chevron_left</i></li>
                                        <li class="waves-effect pagination_link" style="float: right" ><a href="<?php echo e(route('customer.product', ['id' => $product->id, 'page' => $page+1])); ?>"><i class="material-icons">chevron_right</i></a></li>
                                    <?php elseif($page == $pages): ?>
                                        <li class="waves-effect pagination_link"><a href="<?php echo e(route('customer.product', ['id' => $product->id, 'page' => $page-1])); ?>"><i class="material-icons">chevron_left</i></a></li>
                                        <li class="disabled" style="float: right"><i class="material-icons">chevron_right</i></li>
                                    <?php else: ?>
                                        <li class="waves-effect pagination_link"><a href="<?php echo e(route('customer.product', ['id' => $product->id, 'page' => $page-1])); ?>"><i class="material-icons">chevron_left</i></a></li>
                                        <li class="waves-effect pagination_link" style="float: right" ><a href="<?php echo e(route('customer.product', ['id' => $product->id, 'page' => $page+1])); ?>"><i class="material-icons">chevron_right</i></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('select').formSelect();
            $('.slider').slider();
            $('.materialboxed').materialbox();

            $('#description_zoom').click(function () {
                if($('#description').hasClass('flow-text')) $('#description').removeClass('flow-text');
                else $('#description').addClass('flow-text');
            });

            $('.add_cart').click(function () {
                var product_id = $(this).attr('product_id');
                $.ajax({
                    url: "/customer/cart/add/"+product_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Item added to cart'});
                        } else if(statusCode.status==203) {
                            M.toast({html: 'Product already in cart'});
                        }
                    },
                });
            });

            $('.send_review').click(function () {
                var data = $('#make_review').serialize();
                $.ajax({
                    url: "/customer/review",
                    method: 'POST',
                    dataType: 'JSON',
                    data:data,
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Product reviewed'});
                            setTimeout(function () {
                                location.reload();
                            }, 1500)
                        } else if(statusCode.status==203) {
                            M.toast({html: 'Product already reviewed'});
                        }
                    },
                });
            });
            $('.remove_review').click(function () {
                var data = $('#make_review').serialize();
                var product_id = $(this).attr('product_id');
                $.ajax({
                    url: "/customer/review/remove/"+product_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Review Removed'});
                            $('#review_user_<?php echo e(\Illuminate\Support\Facades\Auth::user()->id); ?>').remove();
                        }
                    },
                });
            });

        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/customer/product.blade.php */ ?>