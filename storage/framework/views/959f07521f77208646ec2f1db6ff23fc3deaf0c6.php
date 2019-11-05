<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger mb-3">
                <?php echo e(session()->get('error')); ?>

            </div>
        <?php endif; ?>
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <h5 class="card-title">Welcome ,<?php echo e($fullName); ?></h5>
                        <p>Arabic Name : <?php echo e($student->arabic_name); ?></p>

                        <p>Reservation : <?php echo e($student->reservation->start); ?></p>
                        <p>Group : <?php echo e($student->group->type->type); ?></p>
                    </div>
                    <div class="col-9">
                        <img src="/storage/<?php echo e($student->personalimage); ?>" class="w-100" alt="">
                    </div>
                </div>


                <a href="<?php echo e(route('exam.start')); ?>" class="btn btn-primary">Go to Exam</a>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/exams/home.blade.php ENDPATH**/ ?>