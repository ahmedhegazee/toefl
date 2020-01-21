<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Reservations </h2>


































<reservations-panel
res="<?php echo e($reservations); ?>"
></reservations-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/index.blade.php ENDPATH**/ ?>