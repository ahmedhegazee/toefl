<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Add New Student</h1>
        <form action="<?php echo e(route('student.store')); ?>" method="post" enctype="multipart/form-data">
            <?php echo $__env->make('students.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add New Student')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/create.blade.php ENDPATH**/ ?>