@extends('company.master')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Dodaj nową ofertę pracy</h4>
                            <hr>
                        </div>
                        <div class="content">
                            @if(session()->has('msg'))
                                <div class="alert alert-success">{{session()->get('msg')}}</div>
                            @endif
                            <div class="form-group">
                                {{ Form::open(array('url'=> 'firma/dodajOferteSubmit', 'class'=>'form-group'))}}

                                {{ Form::label('Szukam:')}}
                                {{Form::text('job_title','', array('class' => 'form-control'))}}
                                <br>
                                {{Form::label('Umiejętności kandydata')}}
                                {{Form::textarea('skills','', array('class' => 'form-control','size' => '30x3'))}}
                                <br>
                                {{Form::label('Opis stanowiska')}}
                                {{Form::textarea('requirements','', array('class' => 'form-control','size' => '30x8'))}}
                                <br>
                                {{ Form::label('Kontakt email')}}
                                {{Form::text('contact_email','', array('class' => 'form-control'))}}
                                <br>
                                {{Form::submit('Dodaj ofertę pracy', array('class' => 'btn btn-success'))}}

                                {{ Form::close()}}
                            </div>

                            <div class="footer">
                                <div class="legend">

                                </div>
                                <hr>
                                <div class="stats">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection