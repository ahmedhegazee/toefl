<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Vocab Questions </h2>
        <a href="<?php echo e(route('vocab.create')); ?>" class="btn btn-primary">Add Vocab Question</a>
        <a href="<?php echo e(route('vocab.multiple-questions')); ?>" class="btn btn-primary">Add Multiple Vocab Question</a>

        





































        <display-questions-panel
        exams="<?php echo e($questions); ?>"
        route="<?php echo e(route('vocab.store')); ?>"
        delete-route="<?php echo e(route('vocab.store')); ?>"
        is-paragraph=false
        can-choose=false

        ></display-questions-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/vocab/index.blade.php ENDPATH**/ ?>