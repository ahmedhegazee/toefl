<div class="form-group row">
    <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>

    <div class="col-md-6">
        <input id="title" type="text" pattern="[A-Za-z0-9 ]+" class="form-control @error('title') is-invalid @enderror" name="title"
               value="{{ $paragraph->title??old('title') }}" required autofocus>

        @error('title')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="content" class="col-md-4 col-form-label text-md-right">content</label>

    <div class="col-md-6">
        <textarea name="content" style="min-height: 300px;max-height: 300px;" id="content"  class="form-control @error('content') is-invalid @enderror" cols="30" rows="10" required>{{ $paragraph->content??old('content') }}</textarea>


        @error('content')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>






@csrf

