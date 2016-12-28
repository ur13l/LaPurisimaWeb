@extends('layouts.app')

@section('content')
    <div class="container">
        {{Form::hidden('csrf_token', csrf_token(), array('id' => 'csrf_token'))}}
        {{Form::hidden('_url', url("/"), array('id' => '_url'))}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Promociones
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-nueva">Nueva Promoción</a></li>
                            <li><a data-toggle="tab" href="#tab-activas">Promociones Activas</a></li>
                        </ul>
                        <div class="tab-content">

                            @include('promociones.nueva')
                            <div id="tab-activas" class="tab-pane fade">
                                <h3 class="col-xs-12">Promociones activas</h3>
                                <div class="col-xs-12">

                                    <table id="table-clientes" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section ('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">

@section ('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
@endsection
