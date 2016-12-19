@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Datos del usuario
                            </div>
                        </div>
                    </div>
                    {{Form::hidden('id', $user->id, array('id'=>'_id'))}}
                    {{Form::hidden('_url', url("/"), array('id' => '_url'))}}
                    <div class="panel-body">
                        @if(isset($messages))
                            <div class="alert alert-danger danger">
                                @if($messages == 'no.stock')

                                @endif
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <h4>{{$user->nombre}} </h4>
                                <table class="table ">
                                    <tbody>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{$user->email}}</td>
                                        </tr>
                                        <tr>
                                            <th>Teléfono</th>
                                            <td>{{$user->telefono}}</td>
                                        </tr>
                                        <tr>
                                            <th>Calle</th>
                                            <td>{{$user->calle}}</td>
                                        </tr>
                                        <tr>
                                            <th>Colonia</th>
                                            <td>{{$user->colonia}}</td>
                                        </tr>
                                        <tr>
                                            <th>Código postal</th>
                                            <td>{{$user->codigo_postal}}</td>
                                        </tr>
                                        @if($user->tipo_usuario_id == 2)
                                            <tr>
                                                <th>Estatus</th>
                                                @if($user->datosRepartidor->status == 1)
                                                    <td><span class="label label-success">Activo</span></td>
                                                @else
                                                    <span class="label label-default">Inactivo</span>
                                                @endif

                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h4></h4>
                                <table class="table borderless" style="border:none">
                                    <tbody>
                                        <tr>
                                            <th class="text-center">
                                                @if(isset($user->imagen_usuario))
                                                    <img src="{{url($user->imagen_usuario)}}"  height="130" alt="">
                                                @else
                                                    <img src="{{url("/img/default.png")}}"  height="130" alt="">
                                                @endif
                                            </th>
                                        </tr>
                                        @if($user->tipo_usuario_id == 2)
                                            <tr>
                                                <th class="text-center">
                                                    <span class="glyphicon glyphicon-star"></span>
                                                    {{number_format($user->calificacion, 2)}}
                                                </th>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th class="text-center">
                                                <a href="{{url("/usuarios/editar/$user->id")}}" class="btn btn-primary">Editar perfil</a>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <h4>Historial de pedidos</h4>

                                    <table class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%" id="table-historial-pedidos">
                                        <thead>
                                            <th></th>
                                            <th>Fecha</th>
                                            <th>Status</th>
                                            <th>Usuario</th>
                                            <th>Dirección</th>
                                            <th>Total</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                            </div>

                            @if($user->tipo_usuario_id == 2)
                                <div class="col-xs-12">
                            @else
                                <div class="col-xs-12" style="display:none">
                            @endif
                                <h4>Historial de envíos</h4>

                                <table class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%" id="table-historial-envios">
                                    <thead>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Status</th>
                                    <th>Usuario</th>
                                    <th>Dirección</th>
                                    <th>Total</th>
                                    </thead>
                                    <tbody>
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


@endsection

@section('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tablasDetalleUsuario.js')}}"></script>
@endsection


@section('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">
@endsection