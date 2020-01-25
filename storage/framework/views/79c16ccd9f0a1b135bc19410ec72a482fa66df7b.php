
<!DOCTYPE html>
<html>
<title>Certification</title>
<head>
    <link href='https://fonts.googleapis.com/css?family=Pristina' rel='stylesheet'>

    <style>
        .container {
            position: relative;
            font-family: Arial;
        }

        .VicePresident {
            position: absolute;
            bottom: 90px;
            right: 30px;
            left:600px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20px;
        }

        .FacultyDean {
            position: absolute;
            bottom: 90px;
            right: 370px;
            left: 370px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20px;
        }

        .PublicServiceCenterManager {
            position: absolute;
            bottom: 90px;
            left: 94px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20px;
        }

        .Dated {
            position: absolute;
            bottom: 221px;
            left: 140px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 20px;
        }

        .Score {
            position: absolute;
            bottom: 274px;
            left:725px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 25px;
        }

        .from {
            position: absolute;
            bottom: 334px;
            left: 145px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 25px;
        }

        .till {
            position: absolute;
            bottom: 334px;
            left: 377px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 25px;
        }

        .NumberOfCertification {
            position: absolute;
            bottom: 502px;
            right: 428px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 36px;
        }

        .NameOfStudent {
            position: absolute;
            bottom: 440px;
            left: 340px;
            background-color: #00000000;
            color: #ee7171;
            padding-left: 20px;
            padding-right: 20px;
            font-size: 32px;
            font-family: 'Pristina';
        }
    </style>
</head>
<body>
<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <center>
        <div style="width: 1050px; height: 742.3px" class="container">
            <img  style="width:1050px; height: auto;" src="<?php echo e(asset('img/img1.jpg')); ?>"/>
            <div class="VicePresident">
                <p><?php echo e($vicePresident); ?></p>
            </div>

            <div class="FacultyDean">
                <p><?php echo e($FacultyDean); ?></p>
            </div>

            <div class="PublicServiceCenterManager">
                <p><?php echo e($centerManager); ?></p>
            </div>

            <div class="Dated">
                <p><?php echo e(\Illuminate\Support\Carbon::now()->format('d-m-yy')); ?></p>
            </div>

            <div class="Score">
                <p><?php echo e($student->results->last()->mark); ?></p>
            </div>

            <div class="from">
                <p>05/ Nov /2019</p>
            </div>

            <div class="till">
                <p>07/ Nov /2019</p>
            </div>

            <div class="NumberOfCertification">
                <p><?php echo e($count++); ?></p>
            </div>

            <div class="NameOfStudent">
                <p><?php echo e($student->user->name); ?></p>
            </div>

        </div>
    </center>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html>


<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/certificate.blade.php ENDPATH**/ ?>