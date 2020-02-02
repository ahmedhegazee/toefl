<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

    <div class="col-md-6">
        <input id="title" type="text" pattern="[A-Za-z0-9 ]+" class="form-control <?php if ($errors->has('title')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('title'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="title"
               value="<?php echo e($paragraph->title??old('title')); ?>" required autofocus>

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
    <label for="content" class="col-md-4 col-form-label text-md-right">content</label>

    <div class="col-md-6">
        <textarea name="content" style="min-height: 300px;max-height: 300px;" id="content" pattern="[A-Za-z0-9 ]+" class="form-control <?php if ($errors->has('content')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('content'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" cols="30" rows="10" required><?php echo e($paragraph->content??old('content')); ?></textarea>


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






<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/reading/paragraph/form.blade.php ENDPATH**/ ?>