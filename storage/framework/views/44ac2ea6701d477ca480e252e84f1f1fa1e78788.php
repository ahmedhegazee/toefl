<?php $__env->startSection('content'); ?>
    <div class="container ">
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session()->get('error')); ?>

            </div>
        <?php endif; ?>
        <h2>Grammar Exams </h2>
        <a href="<?php echo e(route('grammar.exam.create')); ?>" class="btn btn-primary">Add Exam</a>
































            <display-exams-panel

                live-route="<?php echo e(route('grammar.live.exam.submit')); ?>"
                route="<?php echo e(route('grammar.exam.store')); ?>"
            ></display-exams-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/exams/index.blade.php ENDPATH**/ ?>