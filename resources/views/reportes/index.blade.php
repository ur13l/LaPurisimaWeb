@extends('layouts.app')

@section('content')
        <div class="container">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="row">
                              <div class="col-md-11">
                          Reporte Productos cargados por repartidor
                              </div>
                              <div class="col-md-1">
                                  <a href="" data-toggle="modal" data-target="#myModal" class="glyphicon glyphicon-question-sign questionMark" aria-hidden="true"></a>
                               </div>
                          </div>
                      </div>
                      <div class="panel-body">
                          @if (count($errors) > 0)
                              <div class="alert alert-danger">
                                  <ul>
                                      @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                      @endforeach
                                  </ul>
                              </div>
                          @endif
                          <div class="form-group">
                              {{ Form::open(array('url' => '/reportes/generar', 'class' => 'form')) }}
                              {{Form::label('telefono', 'Teléfono')}}
                              {{Form::number('telefono', null, array('class'=>'form-control'))}}
                              {{ Form::hidden('invisibleid', '', array('id' => 'invisibleid','class' => 'invisibleid'))}}
                              <span class="help-inline text-danger hidden"></span>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  {!! Form::submit('Generar', array('class'=>'btn btn-primary firstReport')) !!}
                                 <!-- <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary halfleft">Generar</button></a>-->
                              </div>
                              <div class="col-md-6">
                                  {{Form::label('nombre', ' ',array('class'=>'nombre') )}}
                                  {{Form::close() }}
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
      <div class="col-md-10 col-md-offset-1">


          <div class="panel panel-default">
              <div class="panel-heading">
                  <div class="row">
                      <div class="col-md-11">
                          Reporte Entregado a clientes por repartidor
                      </div>
                      <div class="col-md-1">
                          <a href="" data-toggle="modal" data-target="#myModal" class="glyphicon glyphicon-question-sign questionMark" aria-hidden="true"></a>
                      </div>
                  </div>
              </div>
              <div class="panel-body">
                  @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
                  <div class="form-group">
                      {{ Form::open(array('url' => '/reportes/generarClientes', 'class' => 'form')) }}
                      {{Form::label('telefono', 'Teléfono')}}
                      {{Form::number('telefono', null, array('class'=>'form-control'))}}
                      {{ Form::hidden('invisibleid', '', array('id' => 'invisibleid','class' => 'invisibleid'))}}
                      <span class="help-inline text-danger hidden"></span>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                      {!! Form::submit('Generar', array('class'=>'btn btn-primary firstReport')) !!}
                      <!-- <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary halfleft">Generar</button></a>-->
                      </div>
                      <div class="col-md-6">
                          {{Form::label('nombre', ' ',array('class'=>'nombre') )}}
                          {{Form::close() }}
                      </div>
                  </div>
              </div>
          </div>


       <!-- <div class="panel panel-default">
          <div class="panel-heading">
                  Reporte Entregado a clientes por repartidor
            </div>
          <div class="panel-body">
            <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
          </div>-->















        </div>















        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">
                  Reporte  Regresado a bodega por repartidor
              </div>
            <div class="panel-body">
              <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
            </div>
          </div>
          <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                  Reporte  Producto entregado a clientes
                </div>
              <div class="panel-body">
                <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
              </div>
            </div>




    </div>
  </div>
</div>

        <!-- Modal Instructions -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Instrucciones</h4>
                    </div>
                    <div class="modal-body">
                        <p>Podrá obtener un reporte excel de las siguientes maneras:</p>
                        <ol>
                            <li>Escribiendo el teléfono usará un filtro y con generar obtendrá el excel</li>
                            <li>Presionando el botón generar obtendrá un reporte con todos los repartidores</li>
                        </ol>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>

            </div>
        </div>

@endsection

@section('styles')
  <link rel="stylesheet"  href="{{url('css/fileinput.css')}}">
  <link rel="stylesheet"  href="{{url('css/inputform.css')}}">

@endsection



@section('scripts')
<!--<script type="text/javascript" src="/js/fileinput.js"></script>-->
<script type="text/javascript" src="{{url('js/checkTel.js')}}"></script>

@endsection
