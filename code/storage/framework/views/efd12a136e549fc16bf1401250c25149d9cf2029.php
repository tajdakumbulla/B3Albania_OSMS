<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col s6">
            <div class="card">
                <form id="report" method="post" action="<?php echo e(route('admin.reports.orders')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="card-content">
                        <div class="card-title">Orders</div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="from_date" name="from_date" type="text" class="datepicker">
                                <label for="from_date">From Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="to_date" name="to_date" type="text" class="datepicker">
                                <label for="to_date">To Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <select id="status_code" name="status_code">
                                    <option></option>
                                    <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($stat->id); ?>">
                                            <?php echo e($stat->title); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label>Status</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Make
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s6">
            <div class="card">
                <form id="report" method="post" action="<?php echo e(route('admin.reports.sales')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="card-content">
                        <div class="card-title">Sales</div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="from_date_sales" name="from_date_sales" type="text" class="datepicker">
                                <label for="from_date_sales">From Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="to_date_sales" name="to_date_sales" type="text" class="datepicker">
                                <label for="to_date_sales">To Date</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Make
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s6">
            <div class="card">
                <form id="report" method="post" action="<?php echo e(route('admin.reports.products')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="card-content">
                        <div class="card-title">Products</div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="min_quantity" name="min_quantity" required min="0" type="number" class="validate" value="0">
                                <label for="min_quantity">Min Quantity</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="max_quantity" name="max_quantity" required min="0" type="number" class="validate" value="0">
                                <label for="max_quantity">Max Quantity</label>
                            </div>
                        </div>
                        <button class="btn waves-effect waves-light" type="submit" name="action">Make
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function(){
            $('.datepicker').datepicker({
                'format' : 'yyyy-mm-dd'
            });
            $('select').formSelect();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/report/index.blade.php */ ?>