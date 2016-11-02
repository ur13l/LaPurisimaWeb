@extends('layouts.app')

@section('content')
    <div class="container">
        {{Form::hidden('csrf_token', csrf_token(), array('id' => 'csrf_token'))}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Usuarios
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-repartidores">Repartidores</a></li>
                            <li><a data-toggle="tab" href="#tab-clientes">Clientes</a></li>
                            <li><a data-toggle="tab" href="#tab-administradores">Administradores</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-repartidores" class="tab-pane fade in active">
                                <h3>Repartidores</h3>
                                <div class="col-xs-12">

                                    <div class="panel panel-default text-center" style="padding-bottom:15px">
                                        <div class="panel-body ">Registra un nuevo repartidor</div>
                                        <a href="{{url('/pedidos/nuevo')}}" class="btn btn-primary">Nuevo</a>
                                    </div>

                                    <table id="table-repartidores" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Estatus</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div id="tab-clientes" class="tab-pane fade">
                                <h3>Clientes</h3>
                                <div class="col-xs-12">

                                    <div class="panel panel-default text-center" style="padding-bottom:15px">
                                        <div class="panel-body ">Registra un nuevo usuarior</div>
                                        <a href="{{url('/pedidos/nuevo')}}" class="btn btn-primary">Nuevo</a>
                                    </div>

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
                            <div id="tab-administradores" class="tab-pane fade">
                                <h3>Administradores</h3>
                                <div class="col-xs-12">

                                    <div class="panel panel-default text-center" style="padding-bottom:15px">
                                        <div class="panel-body ">Registra un nuevo usuarior</div>
                                        <a href="{{url('/pedidos/nuevo')}}" class="btn btn-primary">Nuevo</a>
                                    </div>

                                    <table id="table-administradores" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
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
    <script type="text/javascript" src="{{url('js/tablasUsuarios.js')}}"></script>
@endsection
