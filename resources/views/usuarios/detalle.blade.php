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

                    <div class="panel-body">
                        @if(isset($messages))
                            <div class="alert alert-danger danger">
                                @if($messages == 'no.stock')
                                    El repartidor no cuenta con stock suficiente.
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
                                                <img src="{{url($user->imagen_usuario)}}"  height="130" alt="">
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
                                                <a href="" class="btn btn-primary">Editar perfil</a>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <h4>Historial de pedidos</h4>

                                    <table class="table table-striped">
                                        <thead>
                                        <th>Imagen</th>
                                        <th>Cant.</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                            </div>

                            <div class="col-xs-12">
                                <h4>Historial de envíos</h4>

                                <table class="table table-striped">
                                    <thead>
                                    <th>Imagen</th>
                                    <th>Cant.</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="row col-xs-12">
                        <h4 >Ubicación</h4>
                        <div class="text-center">



                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    </div>


@endsection



@section('styles')

@endsection