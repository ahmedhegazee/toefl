
                            <div class="form-group row">
                                <label for="start" class="col-md-4 col-form-label text-md-right">{{ __('Start Period') }}</label>

                                <div class="col-md-6">
                                    <input id="start" type="date" class="form-control @error('start') is-invalid @enderror" name="start"  min="{{now()->toDateString()}}" value="{{  $re->start?? now()->toDateString() }}" required  autofocus>
                                    @error('start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="end" class="col-md-4 col-form-label text-md-right">{{ __('End Period') }}</label>

                                <div class="col-md-6">
                                    <input id="end" type="date" class="form-control @error('end') is-invalid @enderror" name="end"  min="{{now()->addDay()->toDateString()}}" value="{{$re->end??now()->addDay()->toDateString()}}" required >

                                    @error('end')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @if(session()->has('error'))
                                <div class="alert alert-danger">{{session()->get('error')}}</div>
                                @endif



@csrf

