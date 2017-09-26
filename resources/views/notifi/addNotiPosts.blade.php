@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Dodaj zgłoszenie o niewłaściwych treściach</div>

                    <div class="panel-body">
                        @if(session()->has('msg'))
                            <div class="alert alert-success">{{session()->get('msg')}}</div>
                        @endif
                        <form class="form-horizontal col-md-12" action="{{url('/dodajZgloszeniePostu')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{$id}}"/>
                            <div class="form-group">
                                <label class="col-md-12">Napisz dlaczego chcesz, aby ten post został usunięty</label>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <textarea id="text" type="text" class="form-control" name="text" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                       Wyślij
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/start.js') }}"></script>
@endsection
