<div class="form-group row">
    <label for="question_text" class="col-md-4 col-form-label text-md-right">Question Content</label>

    <div class="col-md-6">
        <input id="question_text" type="text" class="form-control <?php if ($errors->has('question_text')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('question_text'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="question_text"
               value="<?php echo e($grammar->question_text??old('question_text')); ?>" required autofocus>

        <?php if ($errors->has('question_text')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('question_text'); ?>
        <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
    </div>
</div>

<?php for($i=1;$i<5;$i++): ?>

<div class="form-group row">
    <label for="first_option" class="col-md-4 col-form-label text-md-right"> <?php echo e($options[$i]); ?></label>

    <div class="col-md-6">
        <input id="first_option" type="text" class="form-control  " name="options[]"
            value="<?php echo e($grammar->options[$i-1]->option_text??''); ?>"    required  >


    </div>
</div>
<?php endfor; ?>



<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Correct Answer</label>
    <div class="col-md-6">
        <select id="correct" name="correct" class="form-control">
            <option value="" disabled>Select Correct Answer</option>
            <?php if(isset($grammar)): ?>
                <?php $__currentLoopData = $grammar->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($option->id%4==0?4:$option->id%4); ?>" <?php echo e($option->correct?'selected':''); ?>><?php echo e($options[$option->id%4==0?4:$option->id%4]); ?></option>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
            <?php for($i=1;$i<5;$i++): ?>

            <option value="<?php echo e($i); ?>" ><?php echo e($options[$i]); ?></option>
            <?php endfor; ?>
            <?php endif; ?>

        </select>


</div>
</div>
<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Question Type</label>
    <div class="col-md-6">
        <select id="correct" name="type" class="form-control">
            <option value="" disabled>Select Question Type</option>

            <?php for($i=0;$i<2;$i++): ?>

            <option value="<?php echo e($i+1); ?>" ><?php echo e($types[$i]); ?></option>
            <?php endfor; ?>


        </select>


</div>
</div>


<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/questions/grammar/form.blade.php ENDPATH**/ ?>