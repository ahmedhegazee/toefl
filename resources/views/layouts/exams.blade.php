<div class="form-group row">
    <label for="reservation" class="col-md-4 col-form-label text-md-right">Reservation</label>
    <div class="col-md-6">
        <select id="reservation" name="reservation" class="form-control">
            <option value="" disabled>Select Reservation</option>
            @foreach($reservations as $reservation)
                <option value="{{$reservation->id}}" {{isset($exam)&&$exam->reservation->id==$reservation->id?'selected':''}}>{{$reservation->start.' - '.$reservation->done}}</option>
            @endforeach


        </select>


    </div>
</div>
<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Group Type</label>
    <div class="col-md-6">
        <select id="type" name="type" class="form-control">
            <option value="" disabled>Select Group Type</option>
            @foreach($types as $type)
                <option value="{{$type->id}}" {{isset($exam)&&$exam->groupType->id==$type->id?'selected':''}}>{{$type->type}}</option>
            @endforeach


        </select>


    </div>
</div>

@if(session()->has('error'))
<div class="row alert alert-danger">
    {{session()->get('error')}}
</div>
@endif



@csrf

