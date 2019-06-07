Hello <?php echo e($user->full_name); ?>

You just changed your email address. Please verify your new email using this link:
<?php echo e(route('verify', ['token' => $user->verification_token])); ?>


<?php /* C:\Users\tajda\Desktop\software-project\resources\views/emails/changed.blade.php */ ?>