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
                                <h6><i class="material-icons prefix">title</i> Title: <?php echo e($product->title); ?></h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s4">
                                <h6><i class="material-icons prefix">code</i> Code: <?php echo e($product->code); ?></h6>
                            </div>
                            <div class="col s4">
                                <h6><i class="material-icons prefix">email</i> Price: <?php echo e($product->price); ?></h6>
                            </div>
                            <div class="col s4">
                                <h6><i class="material-icons prefix">email</i> Stock: <?php echo e($product->in_stock); ?></h6>
                            </div>
                            <div class="col s4 right">
                                <svg class="barcode"
                                     jsbarcode-format="auto"
                                     jsbarcode-value="<?php echo e($product->barcode); ?>"
                                     jsbarcode-textmargin="0"
                                     jsbarcode-height="70">
                                </svg>
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
            JsBarcode(".barcode").init();

            $('#description_zoom').click(function () {
                if($('#description').hasClass('flow-text')) $('#description').removeClass('flow-text');
                else $('#description').addClass('flow-text');
            });


            $(document).on('click', '.remove-image', function () {
                var url = $(this).attr('image-url');
                $.ajax({
                    url: "/api/products/<?php echo e($product->id); ?>/image/"+url+"/remove",
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Image removed successfully'});
                            $('#product_images li[id="'+url+'"]').remove();
                            $('.slider').slider();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                });
            });


            $('#add-image-file').change(function () {

                var form = $('#add_image')[0];
                var data = new FormData(form);
                $.ajax({
                    url: "/api/products/<?php echo e($product->id); ?>/add/image",
                    method: 'POST',
                    dataType: 'JSON',
                    data:data,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result, status, statusCode){
                        console.log(result);
                        if(statusCode.status==201){
                            M.toast({html: 'Image added successfully'});
                            var li = '<li id="'+result.data.url+'">' +
                                '<img src="'+result.asset+'"><div class="caption right-align">' +
                                '<i image-url="'+result.data.url+'" style="cursor: pointer" class="remove-image close material-icons">close</i>' +
                                '</div></li>';
                            $('#product_images').append(li);
                            // $('#product_images li[id="'+url+'"]').remove();
                            $('.slider').slider();
                            $('.materialboxed').materialbox();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                });

            });

            $('#add-category').change(function () {
                var category_id = $(this).val();
                $.ajax({
                    url: "/api/products/<?php echo e($product->id); ?>/categories/"+category_id+"/add",
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(result);
                        if(statusCode.status==201){
                            M.toast({html: 'Category added successfully'});
                            var new_category = '<div class="chip">'+result.data.title+'<a class="remove_category" category-id="'+result.data.id+'"><i class="close material-icons">close</i></div>';
                            $('#show-categories').append(new_category);
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                });
            });

            $(document).on('click', '.remove_category', function () {
                var category_id = $(this).attr('category-id');
                $.ajax({
                    url: "/api/products/<?php echo e($product->id); ?>/categories/"+category_id+"/remove",
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(result);
                        if(statusCode.status==201){
                            M.toast({html: 'Category removed successfully'});
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                });
            });
        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/product/show.blade.php */ ?>