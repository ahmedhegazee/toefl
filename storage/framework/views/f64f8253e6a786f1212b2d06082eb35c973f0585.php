<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Grammar Questions in this Exam </h2>


















































        <display-questions-panel

            route="<?php echo e(route('grammar.question.store')); ?>"
            store-route="<?php echo e(route('grammar.exam.questions.store',compact('exam'))); ?>"
            delete-route="<?php echo e(route('grammar.exam.questions.store',compact('exam'))); ?>"
            is-paragraph="false"
            can-choose="true"

            redirect-route="<?php echo e(route('grammar.exam.show',compact('exam'))); ?>"

        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/exams/questions.blade.php ENDPATH**/ ?>