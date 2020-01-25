<table border="2px">

    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Arabic Full Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th></th>
    </tr>
    @foreach($students as $student)
        <tr>
            <td>{{$student->id}}</td>
            <td>{{$student->user->name}}</td>
            <td>{{$student->arabic_name}}</td>
            <td>{{$student->phone}}</td>
            <td>{{$student->user->email}}</td>

            <td>
                <a href="{{route('student.show',['student'=>$student])}}" class="btn btn-primary">Show</a>
            </td>
        </tr>
    @endforeach
</table>
