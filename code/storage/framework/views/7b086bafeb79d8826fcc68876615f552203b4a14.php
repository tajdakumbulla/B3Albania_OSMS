Hello <?php echo e($user->full_name); ?>, welcome to B3Albania.
Thank you for creating an account. Please verify your email using this link:
<?php echo e(route('verify', ['token' => $user->verification_token])); ?>


<?php /* C:\Users\tajda\Desktop\software-project\resources\views/emails/welcome.blade.php */ ?>