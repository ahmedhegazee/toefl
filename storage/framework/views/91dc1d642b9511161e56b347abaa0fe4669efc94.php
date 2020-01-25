<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Grammar Questions </h2>
        <a href="<?php echo e(route('grammar.question.create')); ?>" class="btn btn-primary mr-4">Add Grammar Question</a>
        <a href="<?php echo e(route('grammar.multiple-questions')); ?>" class="btn btn-primary">Add Multiple Grammar Question</a>












































        <display-questions-panel
            exams="<?php echo e($questions1); ?>"
            route="<?php echo e(route('grammar.question.store')); ?>"

            delete-route="<?php echo e(route('grammar.question.store')); ?>"
            is-paragraph=false
            can-choose=false

        ></display-questions-panel>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/questions/index.blade.php ENDPATH**/ ?>