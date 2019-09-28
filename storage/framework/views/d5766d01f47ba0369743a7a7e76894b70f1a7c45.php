
                            <div class="form-group row">
                                <label for="start" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Start Period')); ?></label>

                                <div class="col-md-6">
                                    <input id="start" type="date" class="form-control <?php if ($errors->has('start')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('start'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="start"  min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e($re->start?? now()->toDateString()); ?>" required  autofocus>
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

                            <div class="form-group row">
                                <label for="end" class="col-md-4 col-form-label text-md-right"><?php echo e(__('End Period')); ?></label>

                                <div class="col-md-6">
                                    <input id="end" type="date" class="form-control <?php if ($errors->has('end')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('end'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="end"  min="<?php echo e(now()->addDay()->toDateString()); ?>" value="<?php echo e($re->end??now()->addDay()->toDateString()); ?>" required >

                                    <?php if ($errors->has('end')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('end'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>

                            <?php if(session()->has('error')): ?>
                                <div class="alert alert-danger"><?php echo e(session()->get('error')); ?></div>
                                <?php endif; ?>



<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reservation/form.blade.php ENDPATH**/ ?>