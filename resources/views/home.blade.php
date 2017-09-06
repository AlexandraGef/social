@extends('layouts.app')

@section('content')
    <div class="container">
        <div clas="row">
            @include('layouts.partials.sidebar')
            <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">Tablica</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Zostałeś zalogowany!
                </div>
            </div>
            </div>
        </div>
            </div>

@endsection
