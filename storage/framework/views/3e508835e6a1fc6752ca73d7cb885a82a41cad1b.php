<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Groups in this Reservation </h2>
        <a href="<?php echo e(route('group.create',['re'=>$re])); ?>" class="btn btn-primary">Add Group</a>
        <?php if(session()->has('error')): ?>
        <div class="row alert alert-danger"><?php echo e(session()->get('error')); ?></div>
        <?php endif; ?>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Students Count</th>
                <th></th>
            </tr>
            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($group->id); ?></td>
                    <td><?php echo e($group->name); ?></td>
                    <td><?php echo e($group->students->count()); ?></td>
                    <td>

                        <a href="<?php echo e(route('group.show',['group'=>$group->id,'re'=>$re])); ?>" class="btn btn-primary">Show Students</a>
                        <a href="<?php echo e(route('group.edit',['group'=>$group->id,'re'=>$re])); ?>" class="btn btn-success">Edit Group</a>
                                                <form style="display: inline;" method="post" action="<?php echo e(route('group.generate.exam',['group'=>$group])); ?>">

                                                    <button type="submit" class="btn btn-danger">Generate Exam</button>
                                                    <?php echo csrf_field(); ?>
                                                </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/show.blade.php ENDPATH**/ ?>