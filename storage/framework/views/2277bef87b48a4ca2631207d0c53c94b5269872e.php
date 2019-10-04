<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Reservations </h2>
        <a href="<?php echo e(route('res.create')); ?>" class="btn btn-primary">Add Reservation</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Start</th>
                <th>Students Count</th>
                <th>Max Students Count</th>
                <th>open/close</th>
                <th>Actions</th>
            </tr>
            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($res->id); ?></td>
                    <td><?php echo e($res->start); ?></td>
                    <td><?php echo e($res->students->count()); ?></td>
                    <td><?php echo e($res->max_students); ?></td>
                    <td><?php echo e($res->done); ?></td>

                    <td>
                        <a href="<?php echo e(route('res.show',['re'=>$res])); ?>" class="btn btn-primary">Show</a>
                        <a href="<?php echo e(route('res.edit',['re'=>$res])); ?>" class="btn btn-success">Edit</a>




                        




                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/index.blade.php ENDPATH**/ ?>