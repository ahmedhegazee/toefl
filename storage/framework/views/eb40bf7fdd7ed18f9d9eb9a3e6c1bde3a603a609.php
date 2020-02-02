<?php $__env->startSection('content'); ?>

    <div class="container">

        <div class="row mb-4">
            <div class="col-6">
                <img src="/storage/<?php echo e($student->personalimage); ?>" style="height:400px;" alt="">
            </div>
            <div class="col-6">
                <img src="/storage/<?php echo e($student->nidimage); ?>" style="height:400px;" alt="">

            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <img src="/storage/<?php echo e($student->certificateimage); ?>" style="height:400px;" alt="">

            </div>
            <div class="col-6">
                <img src="/storage/<?php echo e($student->messageimage); ?>" style="height:400px;" alt="">

            </div>
        </div>

        <div class="row justify-content-end pr-5">
            <form action="<?php echo e(route('student.verify',['student'=>$student])); ?>" method="post">
                <?php echo method_field('patch'); ?>












                <button type="submit" class="btn btn-primary">
                    Verify Student
                </button>
                <?php echo csrf_field(); ?>
            </form>

        </div>
        </div>



    <?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/show.blade.php ENDPATH**/ ?>
