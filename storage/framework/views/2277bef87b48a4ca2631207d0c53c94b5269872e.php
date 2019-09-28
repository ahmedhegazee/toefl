<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Reservations </h2>
        <a href="<?php echo e(route('res.create')); ?>" class="btn btn-primary">Add Reservation</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Start</th>
                <th>End</th>
                <th></th>
            </tr>
            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($res->id); ?></td>
                    <td><?php echo e($res->start); ?></td>
                    <td><?php echo e($res->end); ?></td>
                    <td>

                        <a href="<?php echo e(route('res.edit',['re'=>$res])); ?>" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="<?php echo e(route('res.destroy',['re'=>$res])); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/index.blade.php ENDPATH**/ ?>