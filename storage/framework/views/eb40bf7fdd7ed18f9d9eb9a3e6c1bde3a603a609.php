<?php $__env->startSection('content'); ?>

    <div class="container">

        <div class="row">
            <div class="col-6">
                <img src="/storage/<?php echo e($student->personalimage); ?>" style="height:400px;width:400px" alt="">
            </div>
            <div class="col-6">
                <img src="/storage/<?php echo e($student->nidimage); ?>" style="height:400px;width:400px" alt="">

            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <img src="/storage/<?php echo e($student->certificateimage); ?>" style="height:400px;width:400px" alt="">

            </div>
            <div class="col-6">
                <img src="/storage/<?php echo e($student->messageimage); ?>" style="height:400px;width:400px" alt="">

            </div>
        </div>

        </div>

        <div class="row">
            <form action="<?php echo e(route('student.update',['student'=>$student])); ?>" method="post">
                <?php echo method_field('put'); ?>
                <div class="form-group row">
                    <label for="required_score" class="col-md-4 col-form-label text-md-right">Required Score</label>

                    <div class="col-md-6">
                        <input id="required_score" type="number" class="form-control <?php if ($errors->has('required_score')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('required_score'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="required_score" value="<?php echo e(old('required_score')); ?>" required  autofocus>

                        <?php if ($errors->has('required_score')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('required_score'); ?>
                        <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                <button type="submit" class="btn btn-primary">
                    Verify Student
                </button>
                <?php echo csrf_field(); ?>
            </form>

        </div>
    </div>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/students/show.blade.php ENDPATH**/ ?>