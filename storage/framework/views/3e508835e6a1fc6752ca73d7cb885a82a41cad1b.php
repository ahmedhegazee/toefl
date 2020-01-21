<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Groups in this Reservation </h2>

































<groups-panel
data="<?php echo e($groups); ?>"
res-id="<?php echo e($re->id); ?>"
>

</groups-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/show.blade.php ENDPATH**/ ?>