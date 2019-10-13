<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Paragraphs</h2>
        <a href="<?php echo e(route('audio.create')); ?>" class="btn btn-primary">Add Audio</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>type</th>
                <th>Questions </th>

                <th></th>

            </tr>
            <?php $__currentLoopData = $audios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($audio->id); ?></td>
                    <td><?php echo e($audio->title); ?></td>
                    <td><?php echo e($audio->type->type); ?></td>
                    <td><?php echo e($audio->questions->count()); ?></td>

                    <td>
                        <a href="<?php echo e(route('audio.show',['audio'=>$audio])); ?>" class="btn btn-primary">Show</a>
                        <a href="<?php echo e(route('audio.edit',['audio'=>$audio])); ?>" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="<?php echo e(route('audio.destroy',['audio'=>$audio])); ?>">
                            <?php echo method_field('delete'); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <?php echo csrf_field(); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
<div class="row">
    <?php echo e($audios->links()); ?>

</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/index.blade.php ENDPATH**/ ?>