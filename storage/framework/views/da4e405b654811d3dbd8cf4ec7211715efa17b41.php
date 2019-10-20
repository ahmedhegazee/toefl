<table border="2px">

    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Arabic Full Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th></th>
    </tr>
    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($student->id); ?></td>
            <td><?php echo e($student->user()->name); ?></td>
            <td><?php echo e($student->arabic_name); ?></td>
            <td><?php echo e($student->phone); ?></td>
            <td><?php echo e($student->user()->email); ?></td>

            <td>
                <a href="<?php echo e(route('student.show',['student'=>$student])); ?>" class="btn btn-primary">Show</a>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/layouts/students.blade.php ENDPATH**/ ?>