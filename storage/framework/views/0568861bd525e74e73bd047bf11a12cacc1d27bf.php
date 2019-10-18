<?php $__env->startSection('content'); ?>
    <div class="container ">
        <?php if(session()->has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session()->get('error')); ?>

        </div>
        <?php endif; ?>
        <h2>Listening Exams </h2>
        <a href="<?php echo e(route('listening.exam.create')); ?>" class="btn btn-primary">Add Exam</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Reservation Date</th>
                <th>Group Type</th>




                <th>Actions</th>
            </tr>
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($exam->id); ?></td>
                    <td><?php echo e($exam->reservation->start); ?></td>
                    <td><?php echo e($exam->groupType->type); ?></td>



                    <td>
                        <a href="<?php echo e(route('listening.exam.show',['exam'=>$exam])); ?>" class="btn btn-primary">Show</a>
                        <a href="<?php echo e(route('listening.exam.edit',['exam'=>$exam])); ?>" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="<?php echo e(route('listening.exam.destroy',['exam'=>$exam])); ?>">
                            <?php echo method_field('delete'); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <?php echo csrf_field(); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/exams/index.blade.php ENDPATH**/ ?>