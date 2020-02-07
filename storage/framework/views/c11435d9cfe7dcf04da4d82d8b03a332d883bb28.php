<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2><?php echo e($paragraph->title); ?></h2>
        <p>
            <?php echo e($paragraph->content); ?>

        </p><br>
        <a href="<?php echo e(route('paragraph.question.create',['paragraph'=>$paragraph])); ?>" class="btn btn-primary mr-2 mb-3">Add Paragraph Question</a>
        <a href="<?php echo e(route('paragraph.multiple-questions',compact('paragraph'))); ?>" class="btn btn-primary  mb-3">Add Multiple Paragraph Question</a>









































        <display-questions-panel

            route="<?php echo e(route('paragraph.question.store',compact('paragraph'))); ?>"
            delete-route="<?php echo e(route('paragraph.question.store',compact('paragraph'))); ?>"
            is-paragraph=false

        ></display-questions-panel>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/paragraph/show.blade.php ENDPATH**/ ?>