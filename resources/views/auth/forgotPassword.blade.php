@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Resetuj hasło</div>

                    <div class="panel-body">
                        @if(session()->has('info'))
                            <div class="alert alert-info">{{session()->get('info')}}</div>
                        @endif
                        @if(session()->has('err'))
                            <div class="alert alert-danger">{{session()->get('err')}}</div>
                        @endif
                        <form class="form-horizontal" method="post" action="{{url('/setToken')}}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Podaj email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email_address"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Wyślij email
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