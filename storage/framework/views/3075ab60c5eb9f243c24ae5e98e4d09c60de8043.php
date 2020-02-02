<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

    <div class="col-md-6">
        <input id="title" type="text" pattern="[A-Za-z0-9 ]+" class="form-control <?php if ($errors->has('title')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('title'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
               name="title"
               value="<?php echo e($audio->title??old('title')); ?>" required autofocus>

        <?php if ($errors->has('title')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('title'); ?>
        <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
    </div>
</div>

<div class="form-group row">
    <label for="source" class="col-md-4 col-form-label text-md-right"><?php echo e(__('Upload Audio File')); ?></label>

    <div class="col-md-6">
        <input id="source" type="file" class="form-control <?php if ($errors->has('source')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('source'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="source">

<?php if ($errors->has('source')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('source'); ?>
        <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
    </div>
</div>

<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Audio Type</label>
    <div class="col-md-6">
        <select id="type" name="type" class="form-control">
            <option value="" disabled>Select Audio Type</option>
            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option
                    value="<?php echo e($type->id); ?>" <?php echo e(isset($audio)&&$audio->type->id==$type->id?'selected':''); ?>><?php echo e($type->type); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </select>


    </div>
</div>


<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/listening/audio/form.blade.php ENDPATH**/ ?>