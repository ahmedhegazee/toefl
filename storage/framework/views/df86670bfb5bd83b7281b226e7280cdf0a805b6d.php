<?php $__env->startSection('content'); ?>
    <div class="container ">
        <form action="<?php echo e(route('reading.exam.store.paragraphs',compact('exam'))); ?>" method="post">
        <table border="2px solid">
            <tr>
                <th><input type="checkbox"></th>
                <th>ID</th>
                <th>title</th>
                <th>Questions </th>

                <th></th>

            </tr>
            <?php $__currentLoopData = $paragraphs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input type="checkbox" name="paragraphs[]" value="<?php echo e($paragraph->id); ?>" <?php echo e($exam->paragraphs->contains($paragraph->id)?'checked':''); ?>></td>
                    <td><?php echo e($paragraph->id); ?></td>
                    <td><?php echo e($paragraph->title); ?></td>
                    <td><?php echo e($paragraph->questions->count()); ?></td>

                    <td>
                        <a href="<?php echo e(route('paragraph.show',['paragraph'=>$paragraph])); ?>" class="btn btn-primary">Show</a>
                        <a href="<?php echo e(route('paragraph.edit',['paragraph'=>$paragraph])); ?>" class="btn btn-success">Edit</a>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
            <button type="submit" class="btn btn-primary">Add Paragraphs</button>
            <?php echo csrf_field(); ?>
        </form>
<div class="row">
    <?php echo e($paragraphs->links()); ?>

</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/addparagraphs.blade.php ENDPATH**/ ?>