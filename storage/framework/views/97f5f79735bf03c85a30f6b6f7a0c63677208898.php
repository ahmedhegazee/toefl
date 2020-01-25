<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">

                        <div class="row justify-content-between p-2 mb-2">
                            
                            
                            
                            

                            
                            <?php if(auth()->user()->canManageStudentsPanel()): ?>
                                <a href="<?php echo e(route('cpanel.students-panel')); ?>" class="btn btn-primary ">Students</a>
                            <?php endif; ?>
                            <?php if(auth()->user()->canManageReservationsPanel()): ?>
                                <a href="<?php echo e(route('res.index')); ?>" class="btn btn-primary ">Reservations </a>
                            <?php endif; ?>
                            
                            <?php if(auth()->user()->canManageGrammarSection()): ?>
                                <a href="<?php echo e(route('grammar.index')); ?>" class="btn btn-primary ">Grammar Section </a>
                            <?php endif; ?>
                            <?php if(auth()->user()->canManageReadingSection()): ?>
                                <a href="<?php echo e(route('reading.index')); ?>" class="btn btn-primary ">Reading Section </a>
                            <?php endif; ?>
                            <?php if(auth()->user()->canManageListeningSection()): ?>
                                <a href="<?php echo e(route('listening.index')); ?>" class="btn btn-primary ">Listening Section </a>
                            <?php endif; ?>
                        </div>
                        <div class="row justify-content-between p-2">

                            <?php if(auth()->user()->isSuperAdmin()): ?>

                                <a href="<?php echo e(route('cpanel.users-panel')); ?>" class="btn btn-primary ">Users Panel </a>
                                <a href="<?php echo e(route('cpanel.configs-panel')); ?>" class="btn btn-primary ">Configs Panel </a>
                            <?php endif; ?>
                            <?php if(auth()->user()->canManageExamsPanel()): ?>
                                <a href="<?php echo e(route('cpanel.exams-panel')); ?>" class="btn btn-primary ">Exams Panel </a>
                            <?php endif; ?>
                            <?php if(auth()->user()->canPrintCertificates()): ?>
                                <a href="<?php echo e(route('cpanel.certificates-panel')); ?>" class="btn btn-primary ">Certificates
                                    Panel </a>
                            <?php endif; ?>
                            <?php if(auth()->user()->canEditMarks()): ?>
                                <a href="<?php echo e(route('cpanel.marks-panel')); ?>" class="btn btn-primary ">Edit Marks Panel </a>
                            <?php endif; ?>
                        </div>
                        <?php if(auth()->user()->canManageExamsPanel()): ?>
                            <div class="row justify-content-between p-2">
                                <a href="<?php echo e(route('cpanel.student-data')); ?>" class="btn btn-primary ">Edit Student
                                    Marks </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/cpanel/index.blade.php ENDPATH**/ ?>