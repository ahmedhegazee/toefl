<?php $__env->startSection('content'); ?>

    <div class="container">

        <div class="row">
            <div class="col-6">
                <img src="/storage/<?php echo e($student->personalimage); ?>" style="height:400px;width:400px" alt="">
            </div>
            <div class="col-6">
                <img src="/storage/<?php echo e($student->nidimage); ?>" style="height:400px;width:400px" alt="">

            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="/storage/<?php echo e($student->certificateimage); ?>" style="height:400px;width:400px" alt="">

            </div>
            <div class="col-6">
                <img src="/storage/<?php echo e($student->messageimage); ?>" style="height:400px;width:400px" alt="">

            </div>
        </div>
        <div class="row">
            <form action="<?php echo e(route('student.update',['student'=>$student])); ?>" method="post">
                <?php echo method_field('put'); ?>
                <button type="submit" class="btn btn-primary">
                    Verify Student
                </button>
                <?php echo csrf_field(); ?>
            </form>

        </div>
    </div>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/show.blade.php ENDPATH**/ ?>