<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2><?php echo e($audio->title); ?></h2>
        <audio controls>
            <source src="/storage/<?php echo e($audio->source); ?>" type="audio/wav">
            Your browser does not support the audio element.
        </audio>
        <a href="<?php echo e(route('listening.question.create',['audio'=>$audio])); ?>" class="btn btn-primary mb-5">Add Audio Question</a>








































        <display-questions-panel
            exams="<?php echo e($questions); ?>"
            route="<?php echo e(route('listening.question.store',compact('audio'))); ?>"
            delete-route="<?php echo e(route('listening.question.store',compact('audio'))); ?>"
            is-paragraph=false

        ></display-questions-panel>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/show.blade.php ENDPATH**/ ?>