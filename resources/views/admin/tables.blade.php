@extends('admin.master')
<style>
    .table-bordered {
        border: 1px solid #dddddd;
        border-collapse: separate;
        border-left: 0;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .table {
        width: 100%;
        margin-bottom: 20px;
        background-color: transparent;
        border-collapse: collapse;
        border-spacing: 0;
        display: table;
    }

    .widget.widget-table .table {
        margin-bottom: 0;
        border: none;
    }

    .widget.widget-table .widget-content {
        padding: 0;
    }

    .widget .widget-header + .widget-content {
        border-top: none;
        -webkit-border-top-left-radius: 0;
        -webkit-border-top-right-radius: 0;
        -moz-border-radius-topleft: 0;
        -moz-border-radius-topright: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    .widget .widget-content {
        padding: 20px 15px 15px;
        background: #FFF;
        border: 1px solid #D5D5D5;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    .widget .widget-header {
        position: relative;
        height: 40px;
        line-height: 40px;
        background: #E9E9E9;
        background: -moz-linear-gradient(top, #fafafa 0%, #e9e9e9 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fafafa), color-stop(100%, #e9e9e9));
        background: -webkit-linear-gradient(top, #fafafa 0%, #e9e9e9 100%);
        background: -o-linear-gradient(top, #fafafa 0%, #e9e9e9 100%);
        background: -ms-linear-gradient(top, #fafafa 0%, #e9e9e9 100%);
        background: linear-gradient(top, #fafafa 0%, #e9e9e9 100%);
        text-shadow: 0 1px 0 #fff;
        border-radius: 5px 5px 0 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1), inset 0 1px 0 white, inset 0 -1px 0 rgba(255, 255, 255, 0.7);
        border-bottom: 1px solid #bababa;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9');
        -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9')";
        border: 1px solid #D5D5D5;
        -webkit-border-top-left-radius: 4px;
        -webkit-border-top-right-radius: 4px;
        -moz-border-radius-topleft: 4px;
        -moz-border-radius-topright: 4px;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        -webkit-background-clip: padding-box;
    }

    thead {
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }

    .widget .widget-header h3 {
        position: relative;
        left: 45%;
        display: inline-block;
        text-transform: uppercase;
        margin-right: 3em;
        font-size: 14px;
        font-weight: 600;
        color: #555;
        line-height: 18px;
        text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
    }

    th:first-child {
        width: 80%;
    }
</style>
@section('content')
    <div class="content" id="crud">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="content">
                            <div v-if="seen" class="alert alert-success">@{{ msg }}</div>

                            <div class="widget stacked widget-table action-table">
                                <div class="widget-header">
                                    <i class="icon-th-list"></i>
                                    <h3>Baza danych</h3>
                                </div>
                                <div class="widget-content">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nazwa tabeli</th>
                                            <th class="td-actions"></th>
                                            <th class="td-actions"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="table in tables">
                                            <td>@{{ table.Tables_in_bevyy }}</td>
                                            <td class="td-actions">
                                                <a :href="'{{Config::get('url')}}/admin/pokazTabele/' + table.Tables_in_bevyy"
                                                   class="btn btn-small btn-primary">Pokaż
                                                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td class="td-actions">
                                                <a @click="deleteTable(table.Tables_in_bevyy)"
                                                   class="btn btn-small btn-danger">Usuń
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/crud.js') }}"></script>
@endsection

