<?php $__env->startSection('content'); ?>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
    <h3 style="text-align: center">Products</h3>
    <table style="width: 100%; border: black">
        <thead>
        <tr>
            <td>Id</td>
            <td>Title</td>
            <td>Barcode</td>
            <td>Code</td>
            <td>Price</td>
            <td>Quantity Left</td>
        </tr>
        </thead>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($product->id); ?></td>
                <td><?php echo e($product->title); ?></td>
                <td><?php echo e($product->barcode); ?></td>
                <td><?php echo e($product->code); ?></td>
                <td><?php echo e($product->price); ?>&euro;</td>
                <td><?php echo e($product->in_stock); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/report/products.blade.php */ ?>