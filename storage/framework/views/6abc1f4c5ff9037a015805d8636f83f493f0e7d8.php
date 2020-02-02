<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <?php if(isset($message)): ?>
                    <div class='alert alert-success'> <?php echo e($message); ?> </div>
                <?php endif; ?>

                <?php if(session()->has('message')): ?>
                    <div class='alert alert-success'> <?php echo e(session()->get('message')); ?> </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/success.blade.php ENDPATH**/ ?>