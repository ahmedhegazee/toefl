<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Paragraphs</h2>
        <a href="<?php echo e(route('paragraph.create')); ?>" class="btn btn-primary">Add Paragraph</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>Questions </th>

                <th></th>

            </tr>
            <?php $__currentLoopData = $paragraphs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($paragraph->id); ?></td>
                    <td><?php echo e($paragraph->title); ?></td>
                    <td><?php echo e($paragraph->questions->count()); ?></td>

                    <td>
                        <a href="<?php echo e(route('paragraph.show',['paragraph'=>$paragraph])); ?>" class="btn btn-primary">Show</a>
                        <a href="<?php echo e(route('paragraph.edit',['paragraph'=>$paragraph])); ?>" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="<?php echo e(route('paragraph.destroy',['paragraph'=>$paragraph])); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/questions/reading/paragraph/index.blade.php ENDPATH**/ ?>