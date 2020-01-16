@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Full Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required  autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="arabic_name" class="col-md-4 col-form-label text-md-right">Arabic Full Name</label>

                            <div class="col-md-6">
                                <input id="arabic_name" type="text" class="form-control @error('arabic_name') is-invalid @enderror" name="arabic_name" value="{{ old('arabic_name') }}" required  autofocus>

                                @error('arabic_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  required  autofocus>

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
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  required >

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
                        </div>
                        <div class="form-group row">
                            <label for="nidimage" class="col-md-4 col-form-label text-md-right">{{ __('National ID Image') }}</label>

                            <div class="col-md-6">
                                <input id="nidimage" type="file" class="form-control @error('nidimage') is-invalid @enderror" name="nidimage"   >

                                @error('nidimage')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="certificateimage" class="col-md-4 col-form-label text-md-right">{{ __('Certificate Image') }}</label>

                            <div class="col-md-6">
                                <input id="certificateimage" type="file" class="form-control @error('certificateimage') is-invalid @enderror" name="certificateimage"   >

                                @error('certificateimage')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
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
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">How to take exam</label>
                            <div class="col-md-6">
                                <select id="type" name="type" class="form-control">
                                    <option value="" disabled>Select how to take exam</option>

                                    @foreach($groups as $group)
                                        <option value="{{$group->id}}" >{{$group->type->type}}</option>
                                    @endforeach


                                </select>


                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Gender</label>
                            <div class="col-md-6">
                                <select id="type" name="gender" class="form-control">
                                    <option value="" disabled>Select Gender</option>

                                        <option value="1" >Male</option>
                                        <option value="2" >Female</option>


                                </select>


                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="studying" class="col-md-4 col-form-label text-md-right">Studying</label>
                            <div class="col-md-6">
                                <select id="studying" name="studying" class="form-control">
                                    <option value="" disabled>Select Studying</option>

                                        <option value="1" >Ms.c(Master)</option>
                                        <option value="2" >PhD(Doctor)</option>
                                        <option value="3" >Board certified</option>


                                </select>


                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
