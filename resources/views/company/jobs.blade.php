@extends('company.master')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Twoje oferty pracy</h4>
                            <hr>
                            <a class="btn btn-success" href="{{url('/firma/dodajOfertePracy')}}">
                                <i class="text-success"></i>Dodaj ofertę pracy
                            </a>

                        </div>
                        <div class="content">
                            @if(session()->has('msg'))
                                <div class="alert alert-info">{{session()->get('msg')}}</div>
                            @endif
                            <div class="form-group">

                            </div>

                            <div class="footer">
                                <div class="legend">
                                    <table class="jobTable">

                                        <tr>
                                            <th>
                                                Tytuł oferty
                                            </th>
                                            <th>
                                                Umiejętności
                                            </th>
                                            <th>
                                                Opis stanowiska
                                            </th>
                                            <th>
                                                Kontakt
                                            </th>
                                            <th>
                                                Data publikacji
                                            </th>
                                            <th>
                                                Edytuj
                                            </th>
                                            <th>
                                                Usuń
                                            </th>
                                        </tr>
                                        @foreach($jobs as $job)
                                            <tr>

                                                <td>
                                                    {{$job->job_title}}
                                                </td>
                                                <td>
                                                    {{$job->skills}}
                                                </td>
                                                <td>
                                                    {{$job->requirements}}

                                                </td>
                                                <td>
                                                    {{$job->contact_email}}
                                                </td>
                                                <td>
                                                    {{$job->created_at}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-info" href="{{url('/firma/edytujOfertePracy')}}/{{$job->id}}">
                                                        <i class="text-info"></i>Edytuj
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger" href="{{url('/firma/usunOfertePracy')}}/{{$job->id}}">
                                                        <i class="text-danger"></i>Usuń
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
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