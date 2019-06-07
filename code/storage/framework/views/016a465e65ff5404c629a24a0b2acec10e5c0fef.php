<?php $__env->startSection('content'); ?>
    <div class="row card">
        <div class="col s12" style="width: 100%">
            <form id="search_form" method="post" action="<?php echo e(route('browse')); ?>">
                <?php echo csrf_field(); ?>
                
                <input id="page" type="hidden" name="page" value="<?php echo e($page); ?>">
                <div class="col s2" style="padding: 0">
                    <ul style="margin: 0" class="collection with-header">
                        <li class="collection-item">
                            <h5 style="margin: 8px; display: inline">Categories</h5>
                            <div class="switch">
                                <label>Favorites
                                    <input name="favorites" value="0" type="checkbox" <?php if($favorite_selected): ?> checked <?php endif; ?>/>
                                    <span class="lever"></span>
                                </label>
                            </div>
                        </li>
                    <?php
                        $category = $categories->shift();
                        $type_id = $category->category_type_id;
                        $category_select = '<li class="collection-item"><h6>'.$category->type.'</h6></li>';
                        foreach ($categories as $category){
                            if($category->category_type_id != $type_id){
                                $category_select .= '<li class="collection-item"><h6>'.$category->type.'</h6></li>';
                                $type_id = $category->category_type_id;
                            }
                            $checked = '';
                            if(isset($categories_selected)) (in_array($category->id,$categories_selected))?$checked = 'checked':'';
                            $category_select .= '
                            <li style="padding:0.5rem; margin: 0" class="collection-item">
                                <p class="tooltipped" data-position="top" data-tooltip="'.$category->description.'" style="margin:0">
                                    <label>
                                        <input name="categories_selected[]" type="checkbox" value="'.$category->id.'" '.$checked.'/>
                                        <span>'.$category->title.'</span>
                                    </label>
                                </p>
                            </li>';
                        }
                        echo $category_select;
                    ?>
                    </ul>
                </div>
                <div class="col s10" style="padding: 0">
                    <nav>
                        <div class="nav-wrapper teal">
                            <div class="input-field">
                                <input id="search" type="search" name="search" value="<?php echo e($search); ?>">
                                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                                <i class="material-icons">close</i>
                            </div>
                        </div>
                    </nav>
                </div>
            </form>
                <div class="col s10">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col s6">
                                <div class="card" style="height: 35rem">
                                    <div id="images">
                                        <?php if(isset($product->images)): ?>
                                            <div class="slider">
                                                <ul id="product_images" class="slides">
                                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><img alt="" src="<?php echo e(asset('/img/'.$image->url)); ?>"></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col s12">
                                        <div class="col s8">
                                            <a href="<?php echo e(route('customer.product', ['id' => $product->id, 'page' => 1])); ?>"><h5 style="margin: 0"><?php echo e($product->title); ?></h5></a>
                                            <p><?php echo e($product->description); ?></p>
                                        </div>
                                        <div class="col s3">
                                            <h5 style="float: right;"><?php echo e($product->price); ?><i class="tiny material-icons">euro_symbol</i></h5>
                                        </div>
                                        <div class="col s1">
                                            <?php if(in_array($product->id, $wishlist)): ?>
                                                <a class="btn-floating btn-flat white waves-effect waves-red waves-circle"><i favorite_id="<?php echo e($product->id); ?>" style="color: purple;" class="change_favorite material-icons">star</i></a>
                                            <?php else: ?>
                                                <a class="btn-floating btn-flat white waves-effect waves-red waves-circle"><i favorite_id="<?php echo e($product->id); ?>" style="color: black; " class="change_favorite material-icons">star</i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="col s12" style="align-content: center">
                            <ul class="pagination" style="align-content: center">
                                <?php if($pages != 1): ?>
                                    <?php if($page == 1): ?>
                                        <li class="disabled"><i class="material-icons">chevron_left</i></li>
                                        <li class="waves-effect pagination_link" page="<?php echo e($page+1); ?>" style="float: right" ><i class="material-icons">chevron_right</i></li>
                                    <?php elseif($page == $pages): ?>
                                        <li class="waves-effect pagination_link" page="<?php echo e($page-1); ?>"><i class="material-icons">chevron_left</i></li>
                                        <li class="disabled" style="float: right"><i class="material-icons">chevron_right</i></li>
                                    <?php else: ?>
                                        <li class="waves-effect pagination_link" page="<?php echo e($page-1); ?>"><i class="material-icons">chevron_left</i></li>
                                        <li class="waves-effect pagination_link" page="<?php echo e($page+1); ?>" style="float: right" ><i class="material-icons">chevron_right</i></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                </div>
            <div class="fixed-action-btn" style="right: 6rem">
                <?php if($cart_item_num>0): ?>
                    <a href="<?php echo e(route('customer.cart')); ?>" class="btn-floating btn-large red  pulse">
                        <i class="large material-icons">shopping_cart</i>
                    </a>
                <?php else: ?>
                    <a id="cart_no_item" class="btn-floating btn-large red">
                        <i class="large material-icons">shopping_cart</i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function(){
            //$('select').formSelect();
            //$('.materialboxed').materialbox();
            $('.slider').slider();
            $('.fixed-action-btn').floatingActionButton();
            $('.tooltipped').tooltip();

            $('#cart_no_item').click(function () {
                M.toast({html: 'No items in cart!'});
            });

            $('.pagination_link, input:checkbox').click(function () {
                var page = $(this).attr('page');
                $('#page').val(page);
                $('#search_form').submit();
            });

            $('.change_favorite').click(function () {
                var product_id = $(this).attr('favorite_id');
                var this_i = $(this);
                $.ajax({
                    url: "/api/customer/<?php echo e(\Illuminate\Support\Facades\Auth::user()->id); ?>/favorite/"+product_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(result);
                        if(statusCode.status==201){
                            M.toast({html: 'Item added to wishlist'});
                            this_i.css('color', 'purple');
                        } else if(statusCode.status==203) {
                            M.toast({html: 'Item removed from wishlist'});
                            this_i.css('color', 'black');
                        }
                    },
                });
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/customer/browse.blade.php */ ?>