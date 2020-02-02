
<div class="form-group row">
    <label for="content" class="col-md-4 col-form-label text-md-right">Question Content</label>

    <div class="col-md-6">
        <input id="content" pattern="[A-Za-z0-9 ]+" type="text" class="form-control <?php if ($errors->has('content')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('content'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="content"
               value="<?php echo e($question->content??old('content')); ?>"  autofocus required>

        <?php if ($errors->has('content')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('content'); ?>
        <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
    </div>
</div>

<?php for($i=0;$i<4;$i++): ?>

<div class="form-group row">
    <label for="options.<?php echo e($i); ?>" class="col-md-4 col-form-label text-md-right"> <?php echo e($options[$i]); ?></label>

    <div class="col-md-6">
        <input id="options.<?php echo e($i); ?>" type="text" pattern="[A-Za-z0-9 ]+" class="form-control <?php if($errors->has('options.'.$i)): ?> is-invalid <?php endif; ?>" name="options[<?php echo e($i); ?>]"
            value="<?php echo e($question->options[$i]->content??old('options.'.$i)); ?>"       required>
        <?php if ($errors->has('options.'.$i)) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('options.'.$i); ?>
        <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>

    </div>
</div>
<?php endfor; ?>



<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Correct Answer</label>
    <div class="col-md-6">
        <select id="correct" name="correct" class="form-control">
            <option value="" disabled>Select Correct Answer</option>
            <?php if(isset($question)): ?>
                <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option->id%4!=0?$option->id%4:$option->id%4+4); ?>" <?php echo e($option->correct?'selected':''); ?>><?php echo e($options[$option->id%4!=0?$option->id%4-1:$option->id%4+3]); ?></option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
            <?php for($i=0;$i<4;$i++): ?>

            <option value="<?php echo e($i+1); ?>" ><?php echo e($options[$i]); ?></option>
            <?php endfor; ?>
            <?php endif; ?>

        </select>


</div>
</div>


<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/layouts/questions.blade.php ENDPATH**/ ?>