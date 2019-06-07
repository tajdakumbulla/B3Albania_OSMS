<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">

            <div class="card-content">
                <span class="card-title">User Management</span>
                <a class="right btn waves-effect waves-light btn-small blue" href="<?php echo e(route('admin.users.create')); ?>">Create<i class="material-icons right">add</i></a>
                <table id="user-datatable" class="hover row-border order-column stripe nowrap">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>User Level</th>
                        <th>Registered</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#user-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo e(route('datatable.users')); ?>',
            columns: [
                {data: 'id'},
                {data: 'full_name'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'user_level'},
                {data: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/user/index.blade.php */ ?>