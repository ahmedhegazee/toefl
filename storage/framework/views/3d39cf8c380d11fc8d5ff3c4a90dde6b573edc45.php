<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Vocab Questions in this Exam</h2>
        <form action="<?php echo e(route('reading.exam.store.vocab',compact('exam'))); ?>" method="post">
        <table border="2px solid">
            <tr>
                <th><input type="checkbox"></th>

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
                    <td><input type="checkbox" name="questions[]" value="<?php echo e($question->id); ?>" <?php echo e($exam->vocabQuestions->contains($question->id)?'checked':''); ?>></td>
                    <td><?php echo e($question->id); ?></td>
                    <td><?php echo e($question->content); ?></td>
                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td><?php echo e($option->content); ?></td>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($option->correct): ?>
                            <td><?php echo e($option->getCorrectOption($option->id%4==0?4:$option->id%4 )); ?></td>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <td>
                        <a href="<?php echo e(route('vocab.edit',['vocab'=>$question])); ?>" class="btn btn-success">Edit</a>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
            <button type="submit" class="btn btn-primary">Add Questions</button>
            <?php echo csrf_field(); ?>
        </form>
        <?php echo e($questions->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/addvocab.blade.php ENDPATH**/ ?>