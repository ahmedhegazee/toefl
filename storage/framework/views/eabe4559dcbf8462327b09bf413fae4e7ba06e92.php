<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h1>Add Students to <?php echo e($group->name); ?></h1>
        <form action="<?php echo e(route('group.students.store',['group'=>$group])); ?>" method="post">
        <table border="2px">
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>verified</th>
                <th>Group</th>
            </tr>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input type="checkbox" name="students[]" value="<?php echo e($student->id); ?>" <?php echo e($student->group->id==$group->id?'checked':''); ?>></td>
                    <td><?php echo e($student->id); ?></td>
                    <td><?php echo e($student->user()->name); ?></td>
                    <td><?php echo e($student->phone); ?></td>
                    <td><?php echo e($student->verified); ?></td>
                    <td><?php echo e($student->group->name); ?></td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
            <div class="row">
                <?php echo e($students->links()); ?>

            </div>
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add Students')); ?>

            </button>
            <?php echo csrf_field(); ?>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/group/students/index.blade.php ENDPATH**/ ?>