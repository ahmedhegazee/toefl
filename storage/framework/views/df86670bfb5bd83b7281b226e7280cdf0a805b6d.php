<?php $__env->startSection('content'); ?>
    <div class="container ">
































        <display-questions-panel
            exams="<?php echo e($paragraphs); ?>"
            route="<?php echo e(route('paragraph.store')); ?>"
            store-route="<?php echo e(route('reading.exam.paragraph.store',compact('exam'))); ?>"
            is-paragraph=true
            can-choose=true
            checked="<?php echo e($checked); ?>"
            redirect-route="<?php echo e(route('reading.exam.show.paragraphs',compact('exam'))); ?>"
        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/addparagraphs.blade.php ENDPATH**/ ?>