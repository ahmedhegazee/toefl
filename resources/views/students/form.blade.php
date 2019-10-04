<div class="form-group row">
    <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>

    <div class="col-md-6">
        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
               value="{{ isset($student)?$student->user()->name:old('name') }}" required  autofocus>

        @error('name')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

    <div class="col-md-6">
        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
               value="{{ isset($student)?$student->user()->email:old('email') }}"  required  autofocus>

        @error('email')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

    <div class="col-md-6">
        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone"
               value="{{ isset($student)?$student->phone:old('phone') }}"  required >

        @error('phone')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>
<div class="form-group row">
    <label for="personalimage" class="col-md-4 col-form-label text-md-right">{{ __('Personal Image') }}</label>

    <div class="col-md-6">
        <input id="personalimage" type="file" class="form-control @error('personalimage') is-invalid @enderror" name="personalimage"   >

        @error('personalimage')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>                       <div class="form-group row">
    <label for="nidimage" class="col-md-4 col-form-label text-md-right">{{ __('National ID Image') }}</label>

    <div class="col-md-6">
        <input id="nidimage" type="file" class="form-control @error('nidimage') is-invalid @enderror" name="nidimage"   >

        @error('nidimage')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>                       <div class="form-group row">
    <label for="certificateimage" class="col-md-4 col-form-label text-md-right">{{ __('Certificate Image') }}</label>

    <div class="col-md-6">
        <input id="certificateimage" type="file" class="form-control @error('certificateimage') is-invalid @enderror" name="certificateimage"   >

        @error('certificateimage')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>                       <div class="form-group row">
    <label for="messageimage" class="col-md-4 col-form-label text-md-right">{{ __('Message Image') }}</label>

    <div class="col-md-6">
        <input id="messageimage" type="file" class="form-control @error('messageimage') is-invalid @enderror" name="messageimage"   >

        @error('messageimage')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
</div>









@csrf

