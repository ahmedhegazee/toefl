
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
                                <label for="max_students" class="col-md-4 col-form-label text-md-right">{{ __('Maximum number of students') }}</label>

                                <div class="col-md-6">
                                    <input id="max_students" type="number" class="form-control @error('max_students') is-invalid @enderror" name="max_students"  min="0"
                                           value="{{  $re->max_students?? 0 }}" required  autofocus>
                                    @error('max_students')
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

