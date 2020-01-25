<?php $__env->startSection('content'); ?>
    <div class="container ">
        <h2>Reading Exams </h2>
        <a href="<?php echo e(route('reading.exam.create')); ?>" class="btn btn-primary">Add Exam</a>
        
        
        
        
        

        
        

        
        
        
        
        
        
        

        
        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <display-exams-panel
            exams="<?php echo e($jsonExams); ?>"
            live-route="<?php echo e(route('reading.live.exam.submit')); ?>"
            route="<?php echo e(route('reading.exam.store')); ?>"
            is-reading="true"

        ></display-exams-panel>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/exams/index.blade.php ENDPATH**/ ?>