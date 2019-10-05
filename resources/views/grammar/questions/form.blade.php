
@include('layouts.questions')
<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Question Type</label>
    <div class="col-md-6">
        <select id="correct" name="type" class="form-control">
            <option value="" disabled>Select Question Type</option>

            @for($i=0;$i<2;$i++)
            <option value="{{$i+1}}" {{isset($question)&&$question->type->id==($i+1)?'selected':''}}>{{$types[$i]}}</option>
            @endfor


        </select>


</div>
</div>


@csrf

