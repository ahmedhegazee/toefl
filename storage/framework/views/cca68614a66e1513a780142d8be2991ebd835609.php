<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('paragraph.question.update',['question'=>$question,'paragraph'=>$paragraph])); ?>" method="post">
            <?php echo $__env->make('layouts.questions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo method_field('put'); ?>
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Update Reading Question')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/questions/update.blade.php ENDPATH**/ ?>