<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Paragraphs in this Exam</h2>
        <a href="<?php echo e(route('reading.exam.paragraph.add',compact('exam'))); ?>" class="btn btn-primary">Add Paragraphs to this Exam</a>






























        <display-questions-panel

            route="<?php echo e(route('paragraph.store')); ?>"
            delete-route="<?php echo e(route('reading.exam.paragraph.store',compact('exam'))); ?>"
            is-paragraph=true
            can-choose=false

        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/paragraphs.blade.php ENDPATH**/ ?>