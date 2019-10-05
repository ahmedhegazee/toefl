
<?php echo $__env->make('layouts.questions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Question Type</label>
    <div class="col-md-6">
        <select id="correct" name="type" class="form-control">
            <option value="" disabled>Select Question Type</option>

            <?php for($i=0;$i<2;$i++): ?>
            <option value="<?php echo e($i+1); ?>" <?php echo e(isset($question)&&$question->type->id==($i+1)?'selected':''); ?>><?php echo e($types[$i]); ?></option>
            <?php endfor; ?>


        </select>


</div>
</div>


<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/grammar/questions/form.blade.php ENDPATH**/ ?>