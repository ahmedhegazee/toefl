
@include('layouts.questions')
<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Question Type</label>
    <div class="col-md-6">
        <select id="correct" name="type" class="form-control">
            <option value="" disabled>Select Question Type</option>

            @foreach($types as $type)
            <option value="{{$type->id}}" {{isset($question)&&$question->type->id==$type->id?'selected':''}}>{{$type->name}}</option>
            @endforeach


        </select>


</div>
</div>



