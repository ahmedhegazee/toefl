<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1></h1>
        <form action="<?php echo e(route('res.update',['re'=>$re])); ?>" method="post">
            <?php echo method_field('put'); ?>
            <?php echo $__env->make('reservation.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="form-group row">
                <label for="done" class="col-md-4 col-form-label text-md-right">Status</label>
                <div class="col-md-6">
                    <select id="done" name="done" class="form-control">
                        <option value="" disabled>Select Reservation Status</option>
                        <?php $__currentLoopData = $re->doneOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activeOptionKey => $activeOptionValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($activeOptionKey); ?>" <?php echo e($re->done==$activeOptionValue?'selected':''); ?>><?php echo e($activeOptionValue); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if ($errors->has('done')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('done'); ?>
                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">
                <?php echo e(__('Update Reservation')); ?>

            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/update.blade.php ENDPATH**/ ?>