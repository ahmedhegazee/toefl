<?php $__env->startSection('content'); ?>
    <div class="container ">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>verified</th>
                <th></th>
            </tr>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($student->id); ?></td>
                    <td><?php echo e($student->user()->name); ?></td>
                    <td><?php echo e($student->verified); ?></td>
                    <td>
                        <a href="<?php echo e(route('student.show',['student'=>$student])); ?>" class="btn btn-primary">Show</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/index.blade.php ENDPATH**/ ?>