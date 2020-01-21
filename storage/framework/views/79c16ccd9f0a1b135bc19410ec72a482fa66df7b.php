<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificate</title>
    <style>

        #certificate{background: linear-gradient(#c8be75 50%, rgba(255,255,255,0) 0) 0 0, radial-gradient(circle closest-side, #c8be75 50%, rgba(255,255,255,0) 0) 0 0, radial-gradient(circle closest-side, #c8be75 0%, rgba(255,255,255,0) 0) 55px 0 #FFF;background-size: 10.5in 8in;background-repeat: repeat-x;}
        body{ margin: 0;}

        @media  print {
            table{background: linear-gradient(#c8be75 50%, rgba(255,255,255,0) 0) 0 0, radial-gradient(circle closest-side, #c8be75 50%, rgba(255,255,255,0) 0) 0 0, radial-gradient(circle closest-side, #c8be75 0%, rgba(255,255,255,0) 0) 55px 0 #FFF;background-size: 10.5in 8in;background-repeat: repeat-x; -webkit-print-color-adjust: exact; }
        }

        @page  {
            margin-top: 0.5cm;
            margin-bottom: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

    </style>
</head>
<body>
<?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="certificate-container" style="background:#f9f9f9;margin-top:50px;margin-bottom:70px;">
    <table id="certificate" style="width: 900px;margin: 0 auto;text-align: center;padding: 10px;border-style: groove;border-width: 20px;outline: 5px dotted #000;height: 8.5in;outline-offset: -26px;outline-style: double;border-color: #9d8b00;">
        <tr>
            <td><h1 style="font-size: 0.6in; margin: 0; color: #000;">Certificate of TOEFL</h1><h3 style="margin: 0;font-size: 0.25in;color: black;text-transform: uppercase;font-family: sans-serif;">Reg. by UP Government</h3> <p style="font-size: 0.2in;text-transform: uppercase;color: #494000;">Is hereby granted to :</p></td>
        </tr>
        <tr>
            <td>
                <h2 style="color: #000; font-size: 0.4in;margin: 10px 0 0 0; font-family: sans-serif;text-transform: uppercase;"><?php echo e($student->user->name); ?></h2>
            </td>
        </tr>
        <tr>
            <td><img src=".<?php echo e($student->personalimage); ?>" alt="" style="max-width: 300px;max-height: 300px;margin: 0 auto;display: block;border-width: 5px;border-style: double;border-color: #333;box-shadow: 0 5px 10px rgba(0,0,0,0.3);"></td>
        </tr>
        <tr>
            <td>
                <h4 style="margin:0; font-size: 0.16in;font-family: sans-serif;color: #000;">The Covered Member</h4>

                <h5  style="margin: 5px 0 40px; font-size: 0.16in;font-family: sans-serif;color: #000;"><?php echo e($student->results->last()->mark); ?></h5>
            </td>
        </tr>

        <tr>
            <td>
                <h6 style="font-family: sans-serif;font-size: 0.12in;">Reg. by TOEFL</h6>
                <em>Generated : <?php echo e(\Illuminate\Support\Carbon::now()->toDateTimeString()); ?></em>
            </td>
        </tr>
    </table>
</div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html>
<?php /**PATH /Users/ahmedhegazy/Desktop/toefl/toeflsystem/resources/views/certificate.blade.php ENDPATH**/ ?>