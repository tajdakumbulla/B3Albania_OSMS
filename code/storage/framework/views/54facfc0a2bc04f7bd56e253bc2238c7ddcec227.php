<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">Categories</span>
                <a class="right waves-effect waves-light btn modal-trigger" href="#add-category">Create<i class="material-icons right">add</i></a>
                <table id="categories-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">Category Types</span>
                <a class="right waves-effect waves-light btn modal-trigger" href="#add-category-type">Create<i class="material-icons right">add</i></a>
                <table id="category-type-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="modals">
        <div id="add-category" class="modal">
        <div class="modal-content">
            <h4>Create a category</h4>
            <div class="row">
                <form id="ajax-add-category">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input id="description" name="description" type="text" class="validate">
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">edit</i>
                            <input id="title" name="title" type="text" class="validate" required>
                            <label for="title">Title</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="category_type_id">
                                <?php $__currentLoopData = $category_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>"><?php echo e($type->type); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <label>Type</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button id="category-submit" class="waves-effect waves-light btn">Add</button>
        </div>
    </div>

        <div id="add-category-type" class="modal">
        <div class="modal-content">
            <h4>Create a category type</h4>
            <div class="row">
                <form id="ajax-add-category-type">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input id="type" name="type" type="text" class="validate" required>
                            <label for="type">Type</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button id="category-type-submit" class="waves-effect waves-light btn">Add</button>
        </div>
    </div>

        <div id="update-category-type" class="modal">
        <div class="modal-content">
            <h4>Update a category type</h4>
            <div class="row">
                <form id="ajax-update-category-type">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input placeholder="" id="type-title" name="type" type="text" class="validate" required>
                            <label for="type">Type</label>
                        </div>
                    </div>
                    <input id="type_id" type="hidden">
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button id="category-type-update" class="waves-effect waves-light btn">Update</button>
            <button id="delete-category-type" class="btn waves-effect waves-light btn-small red" type="button" name="action">Delete
                <i class="material-icons right">delete_forever</i>
            </button>
        </div>
    </div>

        <div id="update-category" class="modal">
            <div class="modal-content">
                <h4>Update Category</h4>
                <div class="row">
                    <form id="ajax-update-category">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">edit</i>
                                <input placeholder="" id="update-description" name="description" type="text" class="validate">
                                <label for="description">Description</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix">edit</i>
                                <input placeholder="" id="update-title" name="title" type="text" class="validate" required>
                                <label for="title">Title</label>
                            </div>
                            <div class="input-field col s6">
                                <select id="update-type" name="category_type_id">
                                    <?php $__currentLoopData = $category_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->type); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label>Type</label>
                            </div>
                        </div>
                        <input id="category_id" type="hidden" name="category_id">
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button id="category-update-submit" class="waves-effect waves-light btn">Update</button>
                <button id="delete-category" class="btn waves-effect waves-light btn-small red" type="button" name="action">Delete
                    <i class="material-icons right">delete_forever</i>
                </button>
            </div>
    </div>
    </div>





    <script>

        $(document).ready(function(){
            $('.modal').modal();
            $('select').formSelect();

            function reload(){
                setTimeout(function () {
                    location.reload(true);
                }, 1500)
            }

            $('#delete-category').click(function () {
                var category_id = $('#category_id').val();
                $.ajax({
                    url: "/api/category/delete/"+category_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(statusCode.status);
                        if(statusCode.status==201){
                            M.toast({html: 'Deleted Successfully!'});
                            $('#categories-datatable tr[id='+result.data.id+']').remove();
                            M.Modal.getInstance($('#update-category')).close();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        M.Modal.getInstance($('#update-category')).close();
                        M.toast({html: 'ERROR: Category is linked to products!!!'});
                    }
                });
            });

            $('#delete-category-type').click(function () {
                var type_id = $('#type_id').val();
                $.ajax({
                    url: "/api/category/type/delete/"+type_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        console.log(statusCode.status);
                        if(statusCode.status==201){
                            M.toast({html: 'Deleted Successfully!'});
                            $('#category-type-datatable tr[id='+result.data.id+']').remove();
                            M.Modal.getInstance($('#update-category-type')).close();
                            $('#update-type option[value='+result.data.id+']').remove();
                            $('#update-type').formSelect();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    },
                    error: function () {
                        M.Modal.getInstance($('#update-category-type')).close();
                        M.toast({html: 'ERROR: Type is linked to categories!!!'});
                    }
                });
            });

            $(document).on('click', '.update-modal', function () {
                console.log("dfdsfds");
                var category_id = $(this).attr('category-id');
                console.log(category_id);
                $.ajax({
                    url: "/api/categories/"+category_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            $('#update-description').val(result.data.description);
                            $('#update-title').val(result.data.title);
                            $('#category_id').val(result.data.id);
                            var val = result.data.category_type_id;
                            $('#update-type option[value='+val+']').attr('selected','selected');
                            $('#update-type').formSelect();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    }});
            });

            $('#category-type-update').click(function () {
                var data = $('#ajax-update-category-type').serialize();
                $.ajax({
                    url: "/api/category/type/update/"+$('#type_id').val(),
                    method: 'POST',
                    dataType: 'JSON',
                    data:data,
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Updated Successfully!'});
                            var row = $('#category-type-datatable tr[id='+result.data.id+']');
                            row.children().eq(1).html(result.data.type);
                            M.Modal.getInstance($('#update-category-type')).close();
                            reload();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    }
                });
            });

            $('#category-update-submit').click(function () {
                var data = $('#ajax-update-category').serialize();
                $.ajax({
                url: "/api/categories/update/"+$('#category_id').val(),
                method: 'POST',
                dataType: 'JSON',
                data:data,
                success: function(result, status, statusCode){
                    if(statusCode.status==201){
                        M.toast({html: 'Updated Successfully!'});
                        var row = $('#categories-datatable tr[id='+result.data.id+']');
                        row.children().eq(1).html(result.data.title);
                        row.children().eq(2).html(result.data.description);
                        row.children().eq(3).html(result.category_type);
                        M.Modal.getInstance($('#update-category')).close();
                    } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                }});
            });

            $(document).on('click', '.update-type-modal', function () {
                var type_id = $(this).attr('type-id');
                $.ajax({
                    url: "/api/category/type/"+type_id,
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            // console.log(result);
                            $('#type-title').val(result.data.type);
                            $('#type_id').val(result.data.id);
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    }
                });
            });

            $('#category-submit').click(function () {
                var data = $('#ajax-add-category').serialize();
                $.ajax({
                    url: "<?php echo e(route('categories.store')); ?>",
                    method: 'POST',
                    dataType: 'JSON',
                    data:data,
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Created Successfully!'});
                            category_datatable.ajax.reload();
                            M.Modal.getInstance($('#add-category')).close();
                            reload();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    }}
                );
            });

            $('#category-type-submit').click(function () {
                var data = $('#ajax-add-category-type').serialize();
                $.ajax({
                    url: "<?php echo e(route('category.type.store')); ?>",
                    method: 'POST',
                    dataType: 'JSON',
                    data:data,
                    success: function(result, status, statusCode){
                        if(statusCode.status==201){
                            M.toast({html: 'Created Successfully!'});
                            category_types_datatable.ajax.reload();
                            M.Modal.getInstance($('#add-category-type')).close();
                            reload();
                        } else M.toast({html: 'Something went wrong!!! Contact webmaster'});
                    }}
                );
            });

        });
    var category_datatable = $('#categories-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?php echo e(route('datatable.categories')); ?>',
        rowId: 'id',
        columns: [
            {data: 'id'},
            {data: 'title'},
            {data: 'description'},
            {data: 'type'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    var category_types_datatable = $('#category-type-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?php echo e(route('datatable.category.types')); ?>',
        rowId: 'id',
        columns: [
            {data: 'id'},
            {data: 'type'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/category/index.blade.php */ ?>