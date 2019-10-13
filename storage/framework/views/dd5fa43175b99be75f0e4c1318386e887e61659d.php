<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Reading Exams </h2>

        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Name</th>

                <th>Vocab Questions</th>
                <th>Paragraphs</th>

                <th>Actions</th>
            </tr>
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($exam->id); ?></td>
                    <td><?php echo e($exam->group->name); ?></td>

                    <td><?php echo e($exam->vocabQuestions()->count()); ?></td>
                    <td><?php echo e($exam->paragraphs()->count()); ?></td>

                    <td>
                        <a href="<?php echo e(route('reading.exam.show.paragraphs',['exam'=>$exam])); ?>" class="btn btn-primary">Show Paragraphs</a>
                        <a href="<?php echo e(route('reading.exam.show.vocab',['exam'=>$exam])); ?>" class="btn btn-primary">Show Vocab Questions</a>






                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
<div class="row"><?php echo e($exams->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/index.blade.php ENDPATH**/ ?>