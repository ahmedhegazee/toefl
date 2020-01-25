<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Audio Files</h2>
        <a href="<?php echo e(route('audio.create')); ?>" class="btn btn-primary">Add Audio</a>
































        <display-questions-panel
            exams="<?php echo e($audios); ?>"
            route="<?php echo e(route('audio.store')); ?>"
            delete-route="<?php echo e(route('audio.store')); ?>"
            is-paragraph=true
            can-choose=false
        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/index.blade.php ENDPATH**/ ?>