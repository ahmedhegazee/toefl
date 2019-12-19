
<?php echo $__env->make('layouts.questions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Question Type</label>
    <div class="col-md-6">
        <select id="correct" name="type" class="form-control">
            <option value="" disabled>Select Question Type</option>

            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>" <?php echo e(isset($question)&&$question->type->id==$type->id?'selected':''); ?>><?php echo e($type->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </select>


</div>
</div>



<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/questions/form.blade.php ENDPATH**/ ?>