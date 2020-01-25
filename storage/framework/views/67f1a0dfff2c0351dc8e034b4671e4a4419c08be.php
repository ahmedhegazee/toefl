<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center"><p id="timer"></p></div>
        <?php if(!is_null(auth()->user()->getStudent())): ?>
            <input type="hidden" class="form-control"
                   id="id" value="<?php echo e(auth()->user()->getStudent()->id); ?>">
            <input type="hidden" class="form-control"
                   id="name" value="<?php echo e(auth()->user()->name); ?>">
        <?php endif; ?>
        <input type="hidden" id="time" value="<?php echo e($time); ?>">
        <form action="<?php echo e($route); ?>" method="post">
            <?php echo csrf_field(); ?>

            <?php $__currentLoopData = $vocabQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="vocab row justify-content-center  d-none mb-2">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card ">
                                <div class="card-header">
                                    <input type="hidden" class="form-control"
                                           name="vocab" value="<?php echo e($question->id); ?>">
                                    <h3><?php echo e($question->content); ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row form-group option">
                                            <div class="col-1 pr-0 ">
                                                <input type="radio" class="form-control"
                                                       name="vocabAnswers[<?php echo e($question->id); ?>]" value="<?php echo e($option->id); ?>">
                                            </div>
                                            <div class="col-11 pt-2">
                                                <?php echo e($option->content); ?>

                                            </div>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



            <?php $__currentLoopData = $paragraphs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="paragraph  d-none row">
                    <div class="row justify-content-center">
                        <div class="col-12 "><p><?php echo e($paragraph->content); ?></p></div>
                    </div>
                    <div class="row questions justify-content-center">
                    <?php $__currentLoopData = $paragraph->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row question  d-none mb-2 col-md-8">
                            <div class="card ">
                                <div class="card-header">
                                    <input type="hidden" class="form-control"
                                           name="pq" value="<?php echo e($question->id); ?>">
                                    <h3><?php echo e($question->content); ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="row form-group option">
                                            <div class="col-1 pr-0 ">
                                                <input type="radio" class="form-control"
                                                       name="paragraphAnswers[<?php echo e($question->id); ?>]" value="<?php echo e($option->id); ?>">
                                            </div>
                                            <div class="col-11 pt-2">
                                                <?php echo e($option->content); ?>

                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            <div class="row justify-content-center">
                <button type="button" onclick="nextQuestion();" id="next" class="btn btn-primary">Next Question</button>
                <button type="submit" class="btn btn-primary d-none " id="submit">Submit Answers</button>

            </div>
        </form>

    </div>
<?php $__env->stopSection(); ?>
<script src="<?php echo e(asset('js/readingExam.js')); ?>"></script>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/exams/readingExam.blade.php ENDPATH**/ ?>