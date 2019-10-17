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
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/layouts/questions_index_body.blade.php ENDPATH**/ ?>