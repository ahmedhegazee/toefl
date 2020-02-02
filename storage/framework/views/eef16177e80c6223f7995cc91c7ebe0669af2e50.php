<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Add New Grammar Exam</h1>
        <form action="<?php echo e(route('grammar.exam.store')); ?>" method="post">
            <?php echo $__env->make('layouts.exams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row justify-content-end pr-5">
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add Exam')); ?>

            </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/exams/create.blade.php ENDPATH**/ ?>