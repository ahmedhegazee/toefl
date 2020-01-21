<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2><?php echo e($paragraph->title); ?></h2>
        <p>
            <?php echo e($paragraph->content); ?>

        </p>
        <a href="<?php echo e(route('paragraph.question.create',['paragraph'=>$paragraph])); ?>" class="btn btn-primary mb-5">Add Paragraph Question</a>









































        <display-questions-panel
            exams="<?php echo e($questions); ?>"
            route="<?php echo e(route('paragraph.question.store',compact('paragraph'))); ?>"
            delete-route="<?php echo e(route('paragraph.question.store',compact('paragraph'))); ?>"
            is-paragraph=false

        ></display-questions-panel>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/paragraph/show.blade.php ENDPATH**/ ?>