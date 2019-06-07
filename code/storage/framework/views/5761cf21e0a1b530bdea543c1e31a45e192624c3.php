<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="container">
            <div class="card">


                <div class="card-content">
                    <div class="row">
                        <div class="card-title">Images</div>
                        <div class="col s11">
                            <div id="images">
                                <div class="slider">
                                    <ul id="product_images" class="slides">
                                        <?php if(isset($product_images)): ?>
                                            <?php $__currentLoopData = $product_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li id="<?php echo e($image->url); ?>">
                                                    <img src="<?php echo e(asset('/img/'.$image->url)); ?>">
                                                    <div class="caption right-align">
                                                        <i image-url="<?php echo e($image->url); ?>" style="cursor: pointer" class="remove-image close material-icons">close</i>
                                                    </div>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <form id="add_image" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="file-field input-field col s1">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>File</span>
                                        <input id="add-image-file" type="file" name="image">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-title">Information</div>
                    <div class="row">
                        <form id="save_product_form" action="<?php echo e(route('products.update', ['id' => $product->id])); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">edit</i>
                                    <input placeholder="" id="title" name="title" type="text" class="validate" value="<?php echo e($product->title); ?>" required>
                                    <label for="title">Title</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">code</i>
                                    <input placeholder="" value="<?php echo e($product->code); ?>" id="code" min="10000" max="99999" name="code" type="number" class="validate" required>
                                    <label for="code">Code</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">code</i>
                                    <input placeholder="" value="<?php echo e($product->barcode); ?>" id="barcode" min="100000000000" max="999999999999" name="barcode" type="number" class="validate" required>
                                    <label for="barcode">Barcode</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">edit</i>
                                    <input placeholder="" value="<?php echo e($product->price); ?>" id="price" name="price" type="text" class="validate" required>
                                    <label for="price">Price</label>
                                </div>
                                <div class="input-field col s6">
                                    <i class="material-icons prefix">edit</i>
                                    <input placeholder="" value="<?php echo e($product->in_stock); ?>" id="in_stock" name="in_stock" type="text" class="validate" required>
                                    <label for="in_stock">Stock</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">edit</i>
                                    <input placeholder="" value="<?php echo e($product->description); ?>" id="description" name="description" type="text" class="validate" required>
                                    <label for="description">Description</label>
                                </div>
                            </div>
                            
                                
                            
                        </form>

                        <div class="card-title">Categories
                        </div>
                        <div id="show-categories" class="col s12">
                            <?php if(isset($product_categories)): ?>
                                <?php $__currentLoopData = $product_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="chip">
                                        <?php echo e($product_category->title); ?>

                                        <a class="remove_category" category-id="<?php echo e($product_category->id); ?>"><i class="close material-icons">close</i></a>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="input-field col s12">
                            <?php
                                $category = $categories->shift();
                                $type_id = $category->category_type_id;
                                $category_select = '<select id="add-category" name="category"><optgroup label="'.$category->type.'"><option value="'.$category->id.'">'.$category->title.'</option>';
                                foreach ($categories as $category){
                                    if($category->category_type_id != $type_id){
                                        $category_select .= '</optgroup><optgroup label="'.$category->type.'">';
                                        $type_id = $category->category_type_id;
                                    }
                                    $category_select .= '<option value="'.$category->id.'">'.$category->title.'</option>';
                                }
                                $category_select .= '</optgroup></select>';
                                echo $category_select;
                            ?>
                            <label>Add category</label>
                        </div>
                        <div class="input-field col s12">
                            <button id="save_product" type="submit" form="save_product_form" class="waves-effect waves-light btn">Submit</button>
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
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/product/update.blade.php */ ?>