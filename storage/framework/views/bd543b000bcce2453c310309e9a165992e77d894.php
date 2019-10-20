<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h1>Students in <?php echo e($group->name); ?></h1>
        <a href="<?php echo e(route('group.students.show',['group'=>$group])); ?>" class="btn btn-primary">Add Students to this group</a>

            <?php echo $__env->make('layouts.students', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <?php echo e($students->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/group/show.blade.php ENDPATH**/ ?>