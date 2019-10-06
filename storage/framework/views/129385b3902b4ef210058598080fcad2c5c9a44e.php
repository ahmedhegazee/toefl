<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Groups </h2>
        <a href="<?php echo e(route('group.create')); ?>" class="btn btn-primary">Add Group</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Name</th>

                <th>Students Count</th>

                <th>Actions</th>
            </tr>
            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($group->id); ?></td>
                    <td><?php echo e($group->name); ?></td>
                    <td><?php echo e($group->students->count()); ?></td>

                    <td>
                        <a href="<?php echo e(route('group.show',['group'=>$group])); ?>" class="btn btn-primary">Show</a>
                        <a href="<?php echo e(route('group.edit',['group'=>$group])); ?>" class="btn btn-success">Edit</a>





                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/group/index.blade.php ENDPATH**/ ?>