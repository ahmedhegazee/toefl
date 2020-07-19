<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2><?php echo e($audio->title); ?></h2>
        <audio controls>
            <source src="/storage/<?php echo e($audio->source); ?>" type="audio/wav">
            Your browser does not support the audio element.
        </audio>
        <br>
        <a href="<?php echo e(route('listening.question.create',compact('audio'))); ?>" id="add-question" class="btn btn-primary mt-2 mr-4">Add Listening Question</a>
        <a href="<?php echo e(route('listening.multiple-questions',compact('audio'))); ?>" id="multiple-questions" class="btn btn-primary mt-2">Add Multiple Listening Question</a>








































        <display-questions-panel

            route="<?php echo e(route('listening.question.store',compact('audio'))); ?>"
            delete-route="<?php echo e(route('listening.question.store',compact('audio'))); ?>"
            is-paragraph=false

        ></display-questions-panel>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/show.blade.php ENDPATH**/ ?>