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
                        {{ Form::model($user, array('url' => '/producto/' . $action, 'files'=>true, $producto->id)) }}
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
                            {{Form::label('contenido', 'Contenido')}}
                            <div class="input-group">
                                {{Form::number('contenido', null, array('class'=>'form-control', 'required'=>'required', 'min'=>'0', 'max'=>'1000000'))}}
                                <span class="input-group-addon">ml</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-4">
                            {{Form::label('precio', 'Precio')}}
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {{Form::number('precio', null, array('class'=>'form-control currency', 'required'=>'required', 'min'=>'0', 'max'=>'1000000', 'step'=>'0.10'))}}
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            {{Form::label('descripcion', 'Descripción')}}
                            {{Form::textarea('descripcion', null, array('class'=>'form-control', 'rows' => '2'))}}
                        </div>

                        <div class="form-group col-xs-12">
                            <div class="marco-imagen col-xs-12 text-center">
                                @if($action == 'update')
                                    <img src="/{{$producto->imagen}}" id="imagen-view" height="200"/>
                                @else
                                    <img src="" id="imagen-view" />
                                @endif
                            </div>
                            {{Form::label('imagen', 'Imagen')}}
                            {{Form::file('imagen', array('class'=>'file', 'data-show-upload'=>'false', 'data-show-caption'=>'true', 'data-show-preview' => 'false'))}}
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

@section('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tablasDetalleUsuario.js')}}"></script>
@endsection


@section('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">
@endsection