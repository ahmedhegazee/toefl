<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2">
                            
                            
                            


                            <a href="<?php echo e(route('reading.exam.index')); ?>" class="btn btn-primary ">Reading Exams</a>
                            <a href="<?php echo e(route('grammar.exam.index')); ?>" class="btn btn-primary ">Grammar Exams</a>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/cpanel/exams.blade.php ENDPATH**/ ?>