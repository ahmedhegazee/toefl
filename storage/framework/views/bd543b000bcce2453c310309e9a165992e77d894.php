<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h1>Students in <?php echo e($group->name); ?></h1>






        <display-students-panel
            data="<?php echo e($students); ?>"
        ></display-students-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/group/show.blade.php ENDPATH**/ ?>