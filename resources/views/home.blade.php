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
<div class="row">
    <div class="col-md-2 pull-left">
        <img src="" alt="username" style="width:100px; margin:10px">
    </div>
    <div class="col-md-10">
        <h3>user name</h3>
        <p>city and country</p>
    </div>
    <p class="col-md-12">status</p>
</div>
                </div>
            </div>
            </div>
        </div>
            </div>

@endsection
