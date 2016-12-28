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
                            <div id="tab-nueva" class="tab-pane fade in active">
                                <h4 class="col-xs-12">Selecciona el tipo de promoción que deseas.</h4>
                                <div class="clearfix"></div>
                                <br>
                                <div class="row">
                                    <ul class="nav nav-pills col-xs-12 col-xs-offset-1 col-md-offset-3 ">
                                        <li class="col-xs-3 col-md-2 text-center"><a href="">Por usuario</a></li>
                                        <li class="col-xs-3 col-md-2 text-center"><a href="">Por producto</a></li>
                                        <li class="col-xs-3 col-md-2 text-center"><a href="">General</a></li>
                                    </ul>
                                </div>

                                {{Form::open(array('id'=>'form-promo'))}}

                                    <div class="form-group col-xs-12" id="form-group-usuario">
                                        {{Form::label('usuario', 'Usuario')}}
                                        {{Form::text('usuario', '', array('id'=>'usuario', 'class' => 'form-control'))}}
                                    </div>
                                    <div class="form-group col-xs-12 col-md-6" id="form-group-fecha">
                                        {{Form::label('fecha', 'Fecha de vencimiento')}}
                                        {{Form::text('fecha', '', array('id'=>'fecha', 'class' => 'form-control'))}}
                                    </div>
                                {{Form::close()}}
                            </div>
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
