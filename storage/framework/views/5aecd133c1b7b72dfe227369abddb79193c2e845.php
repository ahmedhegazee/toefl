<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('res.store')); ?>" method="post">
            <?php echo $__env->make('reservation.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add Reservation')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/create.blade.php ENDPATH**/ ?>