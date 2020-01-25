
<!DOCTYPE html>
<html>
<title>Certification</title>
<head>
    <link href='https://fonts.googleapis.com/css?family=Pristina' rel='stylesheet'>

    <style>
        @media print {
            .btn{
                display: none !important;
            }
            .container{
                margin: 0;
            }
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn {
            margin-top: .25rem;
            margin-bottom: .25rem;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .btn-primary:hover {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
            cursor: pointer;
        }
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
<button class="btn btn-primary" onclick="myFunction()">Print</button>
<script>
    function myFunction(){
        window.print();
    }
</script>
@foreach($students as $student)
    <center>
        <div style="width: 1050px; height: 742.3px" class="container">
            <img  style="width:1050px; height: auto;" src="{{asset('img/img1.jpg')}}"/>
            <div class="VicePresident">
                <p>{{$vicePresident}}</p>
            </div>

            <div class="FacultyDean">
                <p>{{$FacultyDean}}</p>
            </div>

            <div class="PublicServiceCenterManager">
                <p>{{$centerManager}}</p>
            </div>

            <div class="Dated">
                <p>{{\Illuminate\Support\Carbon::now()->format('d-m-yy')}}</p>
            </div>

            <div class="Score">
                <p>{{$student->results->last()->mark}}</p>
            </div>

            <div class="from">
                <p>05/ Nov /2019</p>
            </div>

            <div class="till">
                <p>07/ Nov /2019</p>
            </div>

            <div class="NumberOfCertification">
                <p>{{$count++}}</p>
            </div>

            <div class="NameOfStudent">
                <p>{{$student->user->name}}</p>
            </div>

        </div>
    </center>

    @endforeach
</body>
</html>



