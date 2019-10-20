<div class="form-group row">
    <label for="reservation" class="col-md-4 col-form-label text-md-right">Reservation</label>
    <div class="col-md-6">
        <select id="reservation" name="reservation" class="form-control">
            <option value="" disabled>Select Reservation</option>
            <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($reservation->id); ?>" <?php echo e(isset($exam)&&$exam->reservation->id==$reservation->id?'selected':''); ?>><?php echo e($reservation->start.' - '.$reservation->done); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </select>


    </div>
</div>
<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Group Type</label>
    <div class="col-md-6">
        <select id="type" name="type" class="form-control">
            <option value="" disabled>Select Group Type</option>
            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($type->id); ?>" <?php echo e(isset($exam)&&$exam->groupType->id==$type->id?'selected':''); ?>><?php echo e($type->type); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </select>


    </div>
</div>

<?php if(session()->has('error')): ?>
<div class="row alert alert-danger">
    <?php echo e(session()->get('error')); ?>

</div>
<?php endif; ?>



<?php echo csrf_field(); ?>

<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/layouts/exams.blade.php ENDPATH**/ ?>