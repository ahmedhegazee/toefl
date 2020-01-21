<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Vocab Questions in this Exam</h2>
        <a href="<?php echo e(route('reading.exam.vocab.index',compact('exam'))); ?>" class="btn btn-primary">Add Vocab Questions to this Exam</a>




































        <display-questions-panel
            exams="<?php echo e($questions); ?>"
            route="<?php echo e(route('vocab.store')); ?>"
            delete-route="<?php echo e(route('reading.exam.vocab.store',compact('exam'))); ?>"
            is-paragraph=false
            can-choose=false

        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/vocab.blade.php ENDPATH**/ ?>