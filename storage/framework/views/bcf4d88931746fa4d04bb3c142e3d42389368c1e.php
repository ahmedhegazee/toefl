<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Paragraphs</h2>
        <a href="<?php echo e(route('paragraph.create')); ?>" class="btn btn-primary">Add Paragraph</a>






























       <display-questions-panel
        exams="<?php echo e($paragraphs); ?>"
        route="<?php echo e(route('paragraph.store')); ?>"
        delete-route="<?php echo e(route('paragraph.store')); ?>"
        is-paragraph=true

        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/paragraph/index.blade.php ENDPATH**/ ?>