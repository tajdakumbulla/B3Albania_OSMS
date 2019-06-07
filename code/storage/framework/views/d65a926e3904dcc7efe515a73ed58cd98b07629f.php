<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">My Orders</span>
                
                <table id="order-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>View</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#order-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(route('customer.orders.datatable')); ?>',
            columns: [
                {data: 'id'},
                {data: 'note'},
                {data: 'title'},
                {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/customer/orders.blade.php */ ?>