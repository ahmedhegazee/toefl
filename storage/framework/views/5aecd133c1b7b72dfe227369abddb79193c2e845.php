<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('res.store')); ?>" method="post">
            <?php echo $__env->make('reservation.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="form-group row">
                <label for="max_students" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Maximum number of students')); ?></label>

                <div class="col-md-6">
                    <input id="max_students" type="number" class="form-control <?php if ($errors->has('max_students')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('max_students'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="max_students"  min="0" value="<?php echo e($re->max_students?? 0); ?>" required  autofocus>
                    <?php if ($errors->has('start')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('start'); ?>
                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Add Reservation')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/create.blade.php ENDPATH**/ ?>