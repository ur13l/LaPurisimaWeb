@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Stock de repartidor
                            </div>
                        </div>
                    </div>
                    {{Form::hidden('id', $user->id, array('id'=>'_id'))}}
                    {{Form::hidden('_url', url("/"), array('id' => '_url'))}}
                    {{csrf_field()}}
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

                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h4></h4>
                                <table class="table borderless" style="border:none">
                                    <tbody>
                                        <tr>
                                            <th class="text-center">
                                                @if(isset($user->imagen_usuario))
                                                    <img src="{{$user->imagen_usuario}}"  height="130" alt="">
                                                @else
                                                    <img src="{{url("/img/default.png")}}"  height="130" alt="">
                                                @endif
                                            </th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                              <div class="col-xs-12" id="errors"> </div>
                            <h4>Seleccione los Productos</h4>
                            <div class="form-group">
                                <div class="col-xs-5 selectContainer">
                                    <select class="form-control" id="productos-select" name="size">
                                        <option value="">Escriba el nombre del producto</option>
                                        @foreach($productos as $producto)
                                            <option value="{{$producto->id}}">{{$producto->nombre}} - ${{number_format($producto->precio,2)}}</option>
                                        @endforeach
                                    </select>
                                    @foreach($productos as $producto)
                                        <input type="hidden" id="{{$producto->id}}_nombre" value="{{$producto->nombre}}">
                                        <input type="hidden" id="{{$producto->id}}_precio" value="{{$producto->precio}}">
                                        <input type="hidden" id="{{$producto->id}}_imagen" value="{{$producto->imagen}}">
                                    @endforeach
                                </div>
                                <div class="col-xs-3">
                                  <button id="agregar-producto" class="btn btn-default" name="button">Agregar producto</button>
                                </div>
                            </div>

                            @if($user->tipo_usuario_id == 2)
                                <div class="col-xs-10 col-xs-offset-1">
                            @else
                                <div class="col-xs-10 col-xs-offset-1" style="display:none">
                            @endif
                                <h4>Stock actual</h4>

                                <table class="table table-striped  table-hover col-xs-10 dt-responsive nowrap " cellspacing="0" width="80%" id="table-stock">
                                  <col width="80">
                                  <col width="180">
                                  <col width="80">
                                  <col width="40">
                                    <thead>
                                    <th>Foto</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    </thead>
                                    <tbody>
                                      @foreach($user->datosRepartidor->productos as $producto)
                                        <tr>
                                          <td><img src="{{$producto->imagen}}" height="70"> <input type="hidden" class="hidden-id" value="{{$producto->id}}"></td>
                                          <td>{{$producto->nombre}}</td>
                                          <td>${{number_format($producto->precio)}}</td>
                                          <td><input class="cantidad form-control text-center" type="number" name="" value="{{$producto->pivot->cantidad}}"></td>
                                        </tr>
                                      @endforeach

                                      @if(count($user->DatosRepartidor->productos) == 0)
                                       <tr>
                                         <td colspan="4" id="empty-stock" class="text-center"> No hay stock asignado a este repartidor</td>
                                       </tr>
                                       @endif
                                    </tbody>
                                </table>

                                <button type="button" id="guardar" class="btn btn-primary" name="button">Guardar</button>
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
    <script type="text/javascript" src="{{url('js/stock.js')}}"></script>

    </script>
@endsection


@section('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">
@endsection
