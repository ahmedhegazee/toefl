<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Audios in this Exam</h2>
        <a href="<?php echo e(route('listening.exam.audio.index',compact('exam'))); ?>" class="btn btn-primary">Add Audios to this Exam</a>
































        <display-questions-panel
            exams="<?php echo e($audios); ?>"
            route="<?php echo e(route('audio.store')); ?>"
            delete-route="<?php echo e(route('listening.exam.audio.store',compact('exam'))); ?>"
            is-paragraph=true
            can-choose=false
        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/exams/show.blade.php ENDPATH**/ ?>