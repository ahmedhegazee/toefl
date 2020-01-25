<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Grammar Questions in this Exam </h2>
        <a href="<?php echo e(route('grammar.exam.questions.index',compact('exam'))); ?>" class="btn btn-primary">Add Questions to this Exam</a>











































        <display-questions-panel
            exams="<?php echo e($questions1); ?>"
            route="<?php echo e(route('grammar.question.store')); ?>"
            delete-route="<?php echo e(route('grammar.exam.questions.store',compact('exam'))); ?>"
            is-paragraph=false
            can-choose=false
        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/exams/show.blade.php ENDPATH**/ ?>