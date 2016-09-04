@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">
              Nuevo Producto
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

            {{ Form::model($producto, array('url' => '/producto/' . $action, 'files'=>true, $producto->id)) }}
              <div class="form-group col-xs-12">
                {{Form::hidden('id', $producto->id)}}
                {{Form::label('nombre', 'Nombre')}}
                {{Form::text('nombre', null, array('class'=>'form-control', 'required'=>'required'))}}
              </div>
              <div class="form-group col-xs-12 col-md-4">
                {{Form::label('stock', 'Stock')}}
                {{Form::number('stock', null, array('class'=>'form-control', 'required'=>'required', 'min'=>'0', 'max'=>'1000000'))}}
              </div>
              <div class="form-group col-xs-12 col-md-4">
                {{Form::label('contenido', 'Contenido ml.')}}
                {{Form::number('contenido', null, array('class'=>'form-control', 'required'=>'required', 'min'=>'0', 'max'=>'1000000'))}}
              </div>
              <div class="form-group col-xs-12 col-md-4">
                {{Form::label('precio', 'Precio')}}
                {{Form::number('precio', null, array('class'=>'form-control currency', 'required'=>'required', 'min'=>'0', 'max'=>'1000000'))}}
              </div>
              <div class="form-group col-xs-12">
                <img src="{{$producto->imagen}}" id="" alt="" />
                {{Form::label('imagen', 'Imagen')}}
                {{Form::file('imagen', array('class'=>'file', 'data-show-upload'=>'false', 'data-show-caption'=>'true', 'data-show-preview' => 'false'))}}
              </div>
              <div class="form-group col-xs-12 col-md-12">
                {{Form::submit('Crear', array('class'=>'btn-primary btn'))}}
              </div>
            {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('styles')
  <link rel="stylesheet" href="/css/fileinput.css">

@endsection

@section('scripts')
  <script type="text/javascript" src="/js/fileinput.js"></script>
@endsection
