<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

    <div class="col-md-6">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
               value="{{ $audio->title??old('title') }}" required autofocus>

        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="source" class="col-md-4 col-form-label text-md-right">{{ __('Upload Audio File') }}</label>

    <div class="col-md-6">
        <input id="source" type="file" class="form-control @error('source') is-invalid @enderror" name="source"   >

        @error('source')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">Audio Type</label>
    <div class="col-md-6">
        <select id="type" name="type" class="form-control">
            <option value="" disabled>Select Audio Type</option>
            @foreach($types as $type)
                <option value="{{$type->id}}" {{isset($audio)&&$audio->type->id==$type->id?'selected':''}}>{{$type->type}}</option>
            @endforeach


        </select>


    </div>
</div>




@csrf

