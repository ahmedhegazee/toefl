<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('grammar.question.store')); ?>" method="post">
            <?php echo $__env->make('grammar.questions.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="row justify-content-end pr-5">
                <button type="submit" class="btn btn-primary">
                    <?php echo e(__('Add Grammar Question')); ?>

                </button>
            </div>

        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cpanel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/questions/create.blade.php ENDPATH**/ ?>