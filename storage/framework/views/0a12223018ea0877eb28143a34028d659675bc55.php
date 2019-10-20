<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2><?php echo e($audio->title); ?></h2>
        <audio controls>
            <source src="/storage/<?php echo e($audio->source); ?>" type="audio/wav">
            Your browser does not support the audio element.
        </audio>
        <a href="<?php echo e(route('listening.question.create',['audio'=>$audio])); ?>" class="btn btn-primary mb-5">Add Audio Question</a>


        <table border="2px solid">

            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>First Option</th>
                <th>Second Option</th>
                <th>Third Option</th>
                <th>Fourth Option</th>
                <th>Correct Answer</th>
                <th></th>


            </tr>
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($question->id); ?></td>
                    <td><?php echo e($question->content); ?></td>
                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($option->content); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($option->correct): ?>
                            <td><?php echo e($option->getCorrectOption($option->id%4==0?4:$option->id%4)); ?></td>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    <td>
                        <a href="<?php echo e(route('listening.question.edit',['question'=>$question,'audio'=>$audio])); ?>" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="<?php echo e(route('listening.question.destroy',['question'=>$question,'audio'=>$audio])); ?>">
                            <?php echo method_field('delete'); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <?php echo csrf_field(); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
<?php echo e($questions->links()); ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/show.blade.php ENDPATH**/ ?>