<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('vocab.store')); ?>" method="post">
            <?php echo $__env->make('layouts.questions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row justify-content-end pr-5">

            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add Vocab Question')); ?>

            </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/vocab/create.blade.php ENDPATH**/ ?>