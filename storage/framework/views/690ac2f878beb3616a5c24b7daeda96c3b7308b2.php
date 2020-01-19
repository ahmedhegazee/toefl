<?php $__env->startSection('content'); ?>
    <div class="container ">


        <form action="<?php echo e(route('student.search')); ?>" method="POST" role="search">
            <?php echo e(csrf_field()); ?>

            <div class="input-group">
                <input type="text" class="form-control" name="q"
                       placeholder="Search students by number"> <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Search
            </button>
        </span>
            </div>
        </form>
        <?php if(session()->has('details')): ?>
            <h1>The search results</h1>
            <table border="2px">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Arabic Full Name</th>
                    <th>Phone</th>
                    <th>verified</th>
                </tr>
                <?php $__currentLoopData = session()->get('details'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($student->id); ?></td>
                        <td><?php echo e($student->user()->name); ?></td>
                        <td><?php echo e($student->arabic_name); ?></td>
                        <td><?php echo e($student->phone); ?></td>
                        <td><?php echo e($student->verified); ?></td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php elseif(session()->has('message')): ?>
            <div class="row alert alert-danger"><?php echo e(session()->get('message')); ?></div>
        <?php else: ?>
            <?php echo $__env->make('layouts.students', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <div class="row">
            <?php echo e($students->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/questions.blade.php ENDPATH**/ ?>
