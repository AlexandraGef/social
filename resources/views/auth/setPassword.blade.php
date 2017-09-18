@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Resetuj hasło</div>

                    <div class="panel-body">
                        @if(session()->has('err'))
                            <div class="alert alert-danger">{{session()->get('err')}}</div>
                        @endif
                        <form class="form-horizontal" method="get" action="{{ url('/setPass') }}">
                            {{ csrf_field() }}

                            <input id="email" type="hidden" class="form-control" name="email"
                                   value="{{ $data[0] -> email}}" required autofocus>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Nowe hasło</label>

                                <div class="col-md-6">
                                    <input id="pass" type="password" class="form-control" name="pass" required>

                                    @if ($errors->has('pass'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('pass') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Powtórz nowe hasło</label>
                                <div class="col-md-6">
                                    <input id="confirm_pass" type="password" class="form-control" name="confirm_pass"
                                           required>

                                    @if ($errors->has('confirm_pass'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('confirm_pass') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Resetuj hasło
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