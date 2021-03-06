<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Product Management</span>
                <a class="right waves-effect waves-light btn modal-trigger" href="#create-product">Create<i class="material-icons right">add</i></a>
                <table id="product-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Barcode</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>


    <div id="create-product" class="modal">
        <div class="modal-content">
            <h4>Create Product</h4>
            <div class="row">
                <form action="<?php echo e(route('products.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input id="title" name="title" type="text" class="validate" required>
                            <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">code</i>
                            <input id="code" name="code" type="number" min="10000" max="99999" class="validate" required>
                            <label for="code">Code</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">code</i>
                            <input id="barcode" name="barcode" type="number" min="100000000000" max="999999999999" class="validate" required>
                            <label for="barcode">Barcode</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <i class="material-icons prefix">edit</i>
                            <input id="price" name="price" type="text" class="validate" required>
                            <label for="price">Price</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix">edit</i>
                            <input id="in_stock" name="in_stock" type="text" class="validate" required>
                            <label for="in_stock">Stock</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">edit</i>
                            <input id="description" name="description" type="text" class="validate" required>
                            <label for="description">Description</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="waves-effect waves-light btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function(){
            $('.modal').modal();
            // $('select').formSelect();
        });


        var datatable = $('#product-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(route('datatable.products')); ?>',
            columns: [
                {data: 'id'},
                {data: 'title'},
                {data: 'code'},
                {data: 'barcode_js'},
                {data: 'price'},
                {data: 'in_stock'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            "initComplete": function(settings, json) {
                JsBarcode(".barcode").init();
            }
        });
        datatable.on( 'draw', function () {
            JsBarcode(".barcode").init();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/product/index.blade.php */ ?>