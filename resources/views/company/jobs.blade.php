@extends('company.master')
@section('content')
    <style>
        table {widht:100%; }
        table th{padding:10px;
            border:solid #5e5e5e 1px;text-align: center}
        table td{padding:10px; border:solid #EDEFF2 1px; }
    </style>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Dodaj nową ofertę pracy</h4>

                        </div>
                        <div class="content">
                            @if(session()->has('msg'))
                                <div class="alert alert-success">{{session()->get('msg')}}</div>
                            @endif
                            <div class="form-group">

                            </div>

                            <div class="footer">
                                <div class="legend">
                            <table>

                                 <tr>
                                     <th>
                                        Tytuł oferty
                                     </th>
                                     <th>
                                        Umiejętności
                                     </th>
                                     <th>
                                         Kontakt
                                     </th>
                                     <th>
                                         Data publikacji
                                     </th>
                                     <th>
                                        Detale
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
                                            {{$job->contact_email}}
                                        </td>
                                        <td>
                                            {{$job->created_at}}
                                        </td>
                                        <td>
                                            <a href="#">Pokaż</a>
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

                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Heading here</h4>
                            <p class="category">sub heading here</p>
                        </div>
                        <div class="content">

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