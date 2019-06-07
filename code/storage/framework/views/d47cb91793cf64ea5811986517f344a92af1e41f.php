<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="card">

            <form method="post" id="create-user" action="<?php echo e(route('users.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row card-content">
                    <span class="card-title">Create User</span>
                    <form class="col s12">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="full_name" name="full_name" type="text" class="validate" required>
                                <label for="full_name">Full Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input id="email" name="email" type="email" class="validate" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">edit</i>
                                <input id="password" name="password" type="password" class="validate" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">edit</i>
                                <input id="password_confirmation" name="password_confirmation" type="password" class="validate" required>
                                <label for="password_confirmation">Confirm Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="postal_code" name="postal_code" type="text" class="validate" required>
                                <label for="postal_code">Postal Code</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phone</i>
                                <input id="phone" name="phone" type="text" class="validate" required>
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <select name="user_level">
                                <option value="" disabled selected>Choose User Level</option>
                                <option value="1">Customer</option>
                                <option value="2">Manager</option>
                                <option value="3">Admin</option>
                            </select>
                            <label>User Level</label>
                        </div>
                        <button id="create-user" class="btn waves-effect waves-light" type="submit" name="action">Submit
                            <i class="material-icons right">send</i>
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
<script>
        $(document).ready(function(){
            $('select').formSelect();
        });

    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /* C:\Users\tajda\Desktop\software-project\resources\views/admin/user/create.blade.php */ ?>