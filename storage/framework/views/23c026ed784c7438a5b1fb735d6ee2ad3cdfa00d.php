<?php $__env->startSection('content'); ?>
    <div class="container">
        <h3 class="page-title">Verify Users</h3>



        <div class="panel panel-default">
            <div class="panel-heading">
                Users List
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped <?php echo e(count($students) > 0 ? 'datatable' : ''); ?> dt-select">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Verified</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if(count($students) > 0): ?>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr >

                                <td><?php echo e($student->user()->name); ?></td>
                                <td><?php echo e($student->phone); ?></td>
                                <td><?php echo e($student->verified?'verified':'not verified'); ?></td>
                                <td>


                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                    <?php endif; ?>
                </table>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <!--Creates Pagination Links-->
                        <?php echo e($students->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/verifier/questions.blade.php ENDPATH**/ ?>
