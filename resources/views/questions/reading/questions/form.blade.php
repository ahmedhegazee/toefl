<div class="form-group row">
    <label for="content" class="col-md-4 col-form-label text-md-right">Question Content</label>

    <div class="col-md-6">
        <input id="content" type="text" class="form-control @error('content') is-invalid @enderror" name="content"
               value="{{ $question->content??old('content') }}" required autofocus>

        @error('content')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

@for($i=0;$i<4;$i++)

<div class="form-group row">
    <label for="first_option" class="col-md-4 col-form-label text-md-right"> {{$options[$i]}}</label>

    <div class="col-md-6">
        <input id="first_option" type="text" class="form-control @error('first_option') is-invalid @enderror" name="options[]"
            value="{{$question->options[$i]->content??''}}"    required  >


    </div>
</div>
@endfor



<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Correct Answer</label>
    <div class="col-md-6">
        <select id="correct" name="correct" class="form-control">
            <option value="" disabled>Select Correct Answer</option>
            @if(isset($question))
                @foreach($question->options as $option)
                    <option value="{{$option->id%4!=0?$option->id%4:$option->id%4+4}}" {{$option->correct?'selected':''}}>{{$options[$option->id%4!=0?$option->id%4-1:$option->id%4+3]}}</option>

                @endforeach
                @else
            @for($i=0;$i<4;$i++)

            <option value="{{$i+1}}" >{{$options[$i]}}</option>
            @endfor
            @endif

        </select>


</div>
</div>


@csrf

