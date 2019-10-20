<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Grammar Questions in this Exam </h2>
        <a href="<?php echo e(route('grammar.exam.questions.show',compact('exam'))); ?>" class="btn btn-primary">Add Questions to this Exam</a>

        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Question Type</th>
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
                    <td><?php echo e($question->type->name); ?></td>
                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($option->content); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($option->correct): ?>
                            <td><?php echo e($option->getCorrectOption($option->id%4==0?4:$option->id%4)); ?></td>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <td>
                        <a href="<?php echo e(route('grammar.question.edit',['question'=>$question])); ?>" class="btn btn-success">Edit Question</a>
                        <form style="display: inline;" method="post"
                              action="<?php echo e(route('grammar.exam.questions.destroy',compact('question','exam'))); ?>">
                            <?php echo method_field('delete'); ?>
                            <button type="submit" class="btn btn-danger">Remove Question</button>
                            <?php echo csrf_field(); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
<div class="row">
    <?php echo e($questions->links()); ?>

</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/exams/show.blade.php ENDPATH**/ ?>