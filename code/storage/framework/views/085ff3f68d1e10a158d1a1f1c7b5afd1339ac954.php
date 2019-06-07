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
    <h3 style="text-align: center">Orders</h3>
    <table>
        <thead>
        <tr>
            <td>User</td>
            <td>Status</td>
            <td>Created at</td>
            <td>Note</td>
        </tr>
        </thead>

        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($order->full_name); ?></td>
                <td><?php echo e($order->title); ?></td>
                <td><?php echo e($order->created_at); ?></td>
                <td><?php echo e($order->note); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.report', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/report/orders.blade.php */ ?>