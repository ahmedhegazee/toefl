<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Reading Exams </h2>
        <a href="<?php echo e(route('reading.exam.create')); ?>" class="btn btn-primary">Add Exam</a>
        <table border="2px solid">
            <tr>
                <th>ID</th>
                <th>Reservation Date</th>


                <th>Vocab Questions</th>
                <th>Paragraphs</th>

                <th>Actions</th>
            </tr>
            <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($exam->id); ?></td>
                    <td><?php echo e($exam->reservation->start); ?></td>


                    <td><?php echo e($exam->vocabQuestions()->count()); ?></td>
                    <td><?php echo e($exam->paragraphs()->count()); ?></td>

                    <td>
                        <a href="<?php echo e(route('reading.live.exam.start',['exam'=>$exam])); ?>" class="btn btn-primary">Live Exam</a>
                        <a href="<?php echo e(route('reading.exam.show.paragraphs',['exam'=>$exam])); ?>" class="btn btn-primary">Show Paragraphs</a>
                        <a href="<?php echo e(route('reading.exam.show.vocab',['exam'=>$exam])); ?>" class="btn btn-primary">Show Vocab Questions</a>
                        <a href="<?php echo e(route('reading.exam.edit',['exam'=>$exam])); ?>" class="btn btn-success">Edit</a>
                        <form style="display: inline;" method="post" action="<?php echo e(route('reading.exam.destroy',['exam'=>$exam])); ?>">
                            <?php echo method_field('delete'); ?>
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <?php echo csrf_field(); ?>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
<div class="row"><?php echo e($exams->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/questions.blade.php ENDPATH**/ ?>
