<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Update Group</h1>
        <form action="<?php echo e(route('student.update',['student'=>$student])); ?>" method="post">
            <?php echo method_field('put'); ?>
            <?php echo $__env->make('students.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Update Student')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/update.blade.php ENDPATH**/ ?>