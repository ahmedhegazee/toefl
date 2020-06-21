<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Add New Reading Exam</h1>
        <form action="<?php echo e(route('reading.exam.store')); ?>" method="post">
            <?php echo $__env->make('layouts.exams', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row justify-content">

            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add Exam')); ?>

            </button>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/create.blade.php ENDPATH**/ ?>