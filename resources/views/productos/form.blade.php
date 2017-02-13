@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">
          @if($action == 'update')
            Actualizar Producto
          @else
            Nuevo Producto
          @endif

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

            {{ Form::model($producto, array('url' => '/producto/' . $action, 'id'=>'form-producto',  'files'=>true, $producto->id)) }}
              <div class="form-group col-xs-12">
                {{Form::hidden('id', $producto->id)}}
                {{Form::label('nombre', 'Nombre')}}
                {{Form::text('nombre', null, array('class'=>'form-control'))}}
              </div>
              <div class="form-group col-xs-12 col-md-4">
                {{Form::label('stock', 'Stock')}}
                {{Form::number('stock', null, array('class'=>'form-control', 'min'=>'0', 'max'=>'1000000'))}}
              </div>
              <div class="form-group col-xs-12 col-md-4">
                {{Form::label('contenido', 'Contenido')}}
                  <div class="input-group">
                      {{Form::number('contenido', null, array('class'=>'form-control', 'min'=>'0', 'max'=>'1000000'))}}
                      <span class="input-group-addon">ml</span>
                  </div>
              </div>
              <div class="form-group col-xs-12 col-md-4">
                {{Form::label('precio', 'Precio')}}
                  <div class="input-group">
                      <span class="input-group-addon">$</span>
                      {{Form::number('precio', null, array('class'=>'form-control currency', 'min'=>'0', 'max'=>'1000000', 'step'=>'0.10'))}}
                  </div>
              </div>
              <div class="form-group col-xs-12">
                  {{Form::label('descripcion', 'Descripción')}}
                  {{Form::textarea('descripcion', null, array('class'=>'form-control', 'rows' => '2'))}}
              </div>

              <div class="form-group col-xs-12">
                <div class="marco-imagen col-xs-12 text-center">
                  @if($action == 'update')
                    <img src="{{$producto->imagen}}" id="imagen-view" height="200"/>
                  @else
                    <img src="" id="imagen-view" />
                  @endif
                </div>

                  {{Form::label('imagen', 'Imagen')}}
                <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" id="tab-url" href="#url">Desde URL</a></li>
                    <li><a data-toggle="tab" id="tab-archivo" href="#archivo">Desde archivo</a></li>
                </ul>

                  <div class="tab-content">
                      <div id="url" class="tab-pane fade in active">
                            {{Form::text('url-input', $producto->imagen, array('class'=>'form-control', 'id'=>'url-input'))}}
                      </div>
                      <div id="archivo" class="tab-pane fade">
                          {{Form::file('imagen', array('class'=>'file', 'data-show-upload'=>'false', 'data-show-caption'=>'true', 'data-show-preview' => 'false'))}}
                      </div>
                  </div>

              </div>
              <div class="form-group col-xs-12 col-md-12">
                @if($action == 'update')
                  {{Form::submit('Actualizar', array('class'=>'btn-primary btn'))}}
                @else
                  {{Form::submit('Crear', array('class'=>'btn-primary btn'))}}
                @endif
              </div>
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('styles')
  <link rel="stylesheet" href="{{url('css/fileinput.css')}}">
  <link rel="stylesheet" href="{{url('css/circlecrop.css')}}">
@endsection

@section('scripts')
  <script type="text/javascript" src="{{url("/js/fileinput.js")}}"></script>
  <script type="text/javascript" src="{{url("/js/dynamicImage.js")}}"></script>
  <script type="text/javascript" src="{{url("/js/validations.js")}}"></script>
  <script type="text/javascript" src="{{url("/js/productValidations.js")}}"></script>
@endsection
