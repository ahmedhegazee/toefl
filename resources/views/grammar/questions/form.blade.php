<div class="form-group row">
    <label for="question_text" class="col-md-4 col-form-label text-md-right">Question Content</label>

    <div class="col-md-6">
        <input id="question_text" type="text" class="form-control @error('question_text') is-invalid @enderror" name="question_text"
               value="{{ $grammar->question_text??old('question_text') }}" required autofocus>

        @error('question_text')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

@for($i=1;$i<5;$i++)

<div class="form-group row">
    <label for="first_option" class="col-md-4 col-form-label text-md-right"> {{$options[$i]}}</label>

    <div class="col-md-6">
        <input id="first_option" type="text" class="form-control  " name="options[]"
            value="{{$grammar->options[$i-1]->option_text??''}}"    required  >


    </div>
</div>
@endfor



<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Correct Answer</label>
    <div class="col-md-6">
        <select id="correct" name="correct" class="form-control">
            <option value="" disabled>Select Correct Answer</option>
            @if(isset($grammar))
                @foreach($grammar->options as $option)
                    <option value="{{$option->id%4==0?4:$option->id%4}}" {{$option->correct?'selected':''}}>{{$options[$option->id%4==0?4:$option->id%4]}}</option>

                @endforeach
                @else
            @for($i=1;$i<5;$i++)

            <option value="{{$i}}" >{{$options[$i]}}</option>
            @endfor
            @endif

        </select>


</div>
</div>
<div class="form-group row">
    <label for="correct" class="col-md-4 col-form-label text-md-right">Question Type</label>
    <div class="col-md-6">
        <select id="correct" name="type" class="form-control">
            <option value="" disabled>Select Question Type</option>

            @for($i=0;$i<2;$i++)

            <option value="{{$i+1}}" >{{$types[$i]}}</option>
            @endfor


        </select>


</div>
</div>


@csrf

