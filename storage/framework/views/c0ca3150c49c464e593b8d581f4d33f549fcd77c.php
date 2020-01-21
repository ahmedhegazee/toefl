<link rel="stylesheet" href="<?php echo e(asset('css/audioAnimation.css')); ?>">
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center"><p id="timer"></p></div>
        <?php if(!is_null(auth()->user()->getStudent())): ?>
            <input type="hidden" class="form-control"
                   id="id" value="<?php echo e(auth()->user()->getStudent()->id); ?>">
        <?php endif; ?>
        <input type="hidden" id="time" value="<?php echo e($time); ?>">
        <form action="<?php echo e($route); ?>" method="post">
        <?php echo csrf_field(); ?>

        <!--- Short Conversations-->
            <?php $__currentLoopData = $shortConversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shortConversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="short d-none row">
                    <div class="row justify-content-center">
                        <h1>Short Conversation </h1>
                        <audio  class="audio"  muted="muted" onended="showQuestion();" preload="auto">
                            <source src="/storage/<?php echo e($shortConversation->source); ?>" type="audio/ogg">
                            <source src="/storage/<?php echo e($shortConversation->source); ?>" type="audio/mpeg">
                            <source src="/storage/<?php echo e($shortConversation->source); ?>" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>

                    </div>
                    <div class="row justify-content-center">
                        <div class="animation ">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                   <div class="row questions justify-content-center">
                       <?php $__currentLoopData = $shortConversation->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <div class="row question  d-none mb-2 col-md-8">
                                   <div class="card " >
                                       <div class="card-header">
                                           <input type="hidden" class="form-control"
                                                  name="questions" value="<?php echo e($question->id); ?>">
                                           <h3><?php echo e($question->content); ?></h3>
                                       </div>
                                       <div class="card-body">
                                           <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <div class="row form-group option">
                                                   <div class="col-1 pr-0 ">
                                                       <input type="radio" class="form-control"
                                                              name="listeningAnswers[<?php echo e($question->id); ?>]"
                                                              value="<?php echo e($option->id); ?>"></div>
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
        <!--Long Conversations-->
            <?php $__currentLoopData = $longConversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $longConversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="long  d-none row">
                    <div class="row justify-content-center">
                        <h1>Long Conversation </h1>

                        <audio  class="audio " muted="muted" onended="showQuestion();">
                            <source src="/storage/<?php echo e($longConversation->source); ?>" type="audio/ogg">
                            <source src="/storage/<?php echo e($longConversation->source); ?>" type="audio/mpeg">
                            <source src="/storage/<?php echo e($longConversation->source); ?>" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <div class="row justify-content-center">
                        <div class="animation ">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="row questions justify-content-center">
                        <?php $__currentLoopData = $longConversation->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row question  d-none mb-2 col-md-8">
                                <div class="card ">
                                    <div class="card-header">
                                        <input type="hidden" class="form-control"
                                               name="questions" value="<?php echo e($question->id); ?>">
                                        <h3><?php echo e($question->content); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row form-group option">
                                                <div class="col-1 pr-0 ">
                                                    <input type="radio" class="form-control"
                                                           name="listeningAnswers[<?php echo e($question->id); ?>]"
                                                           value="<?php echo e($option->id); ?>"></div>
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

        <!--Speech-->
            <?php $__currentLoopData = $speeches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $speech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="speech  d-none row">
                    <div class="row justify-content-center">
                        <h1>Speech </h1>

                        <audio  class="audio " muted="muted" onended="showQuestion();">
                            <source src="/storage/<?php echo e($speech->source); ?>" type="audio/ogg">
                            <source src="/storage/<?php echo e($speech->source); ?>" type="audio/mpeg">
                            <source src="/storage/<?php echo e($speech->source); ?>" type="audio/wav">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <div class="row justify-content-center">
                        <div class="animation ">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="row questions justify-content-center">
                        <?php $__currentLoopData = $speech->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row question  d-none mb-2 col-md-8">
                                <div class="card ">
                                    <div class="card-header">
                                        <input type="hidden" class="form-control"
                                               name="questions" value="<?php echo e($question->id); ?>">
                                        <h3><?php echo e($question->content); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row form-group option">
                                                <div class="col-1 pr-0 ">
                                                    <input type="radio" class="form-control"
                                                           name="listeningAnswers[<?php echo e($question->id); ?>]"
                                                           value="<?php echo e($option->id); ?>">
                                                </div>
                                                <div class="col-11 pt-2">
                                                    <div class="col-11 pt-2">
                                                        <?php echo e($option->content); ?>

                                                    </div>
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
                <button type="button" onclick="nextQuestion();" id="next" class="btn btn-primary d-none">Next Question
                </button>
                <button type="submit" class="btn btn-primary d-none " id="submit">Submit Answers</button>

            </div>
        </form>

    </div>
<?php $__env->stopSection(); ?>
<script src="<?php echo e(asset('js/listeningExam.js')); ?>"></script>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/exams/listeningExam.blade.php ENDPATH**/ ?>