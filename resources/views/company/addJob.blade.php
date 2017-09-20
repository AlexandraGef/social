@extends('company.master')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Dodaj nową ofertę pracy</h4>

                        </div>
                        <div class="content">
                            @if(session()->has('msg'))
                                <div class="alert alert-success">{{session()->get('msg')}}</div>
                            @endif
                            <div class="form-group">
                                {{ Form::open(['url'=> 'firma/dodajOferteSubmit'])}}

                                {{ Form::label('Szukam:')}}
                                {{Form::text('job_title')}}
                                <br><br>
                                {{Form::label('Umiejętności')}}
                                <br>
                                {{Form::label('HTML')}}
                                {{Form::checkbox('skills[]','HTML')}}

                                {{Form::label('CSS')}}
                                {{Form::checkbox('skills[]','CSS')}}

                                {{Form::label('PHP')}}
                                {{Form::checkbox('skills[]','PHP')}}
                                <br><br>
                                {{Form::label('Wymagania')}}
                                {{Form::textarea('requirements')}}
                                <br><br>
                                {{ Form::label('Kontakt')}}
                                {{Form::text('contact_email')}}
                                <br><br>
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