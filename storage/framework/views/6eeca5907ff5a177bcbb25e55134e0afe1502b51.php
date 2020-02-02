<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('audio.update',['audio'=>$audio])); ?>" method="post" enctype="multipart/form-data">
            <?php echo $__env->make('listening.audio.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo method_field('put'); ?>
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Update Audio')); ?>

            </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/update.blade.php ENDPATH**/ ?>