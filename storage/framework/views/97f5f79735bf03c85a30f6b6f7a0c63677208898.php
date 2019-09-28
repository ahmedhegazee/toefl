<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny',\App\Student::class)): ?>
                            <a href="<?php echo e(route('student.index')); ?>" class="btn btn-primary ">Verify Students</a>
                            <?php endif; ?>
                            <a href="" class="btn btn-primary ">Questions</a>
                            <a href="" class="btn btn-primary ">Students</a>
                            <a href="<?php echo e(route('res.index')); ?>" class="btn btn-primary ">Reservations </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/cpanel/index.blade.php ENDPATH**/ ?>