<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Audios in this Exam </h2>







































        <display-questions-panel
            exams="<?php echo e($audios); ?>"
            route="<?php echo e(route('audio.store')); ?>"
            store-route="<?php echo e(route('listening.exam.audio.store',compact('exam'))); ?>"
            is-Audio="true"
            can-choose=true
            checked="<?php echo e($checked); ?>"
            redirect-route="<?php echo e(route('listening.exam.show',compact('exam'))); ?>"
        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/exams/audios.blade.php ENDPATH**/ ?>
