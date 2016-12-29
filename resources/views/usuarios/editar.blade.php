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
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-xs-10 col-xs-offset-1">
                            {{ Form::model($user, array('url' => '/usuarios/' . $action, 'id'=>'form-usuario', 'files'=>true, $user->id)) }}

                            <div class="form-group col-xs-12">
                                {{Form::hidden('id', $user->id)}}
                                {{Form::label('nombre', 'Nombre')}}
                                {{Form::text('nombre', null, array('class'=>'form-control'))}}

                            </div>
                            <div class="form-group col-xs-12  col-md-6">
                                {{Form::label('telefono', 'Teléfono')}}
                                @if ($action == "create")
                                    {{Form::text('telefono', null, array('class'=>'form-control'))}}
                                @else
                                    {{Form::text('telefono', null, array('class'=>'form-control', 'disabled'=>'disabled'))}}
                                @endif
                            </div>

                            <div class="form-group col-xs-12 col-md-6">
                                {{Form::label('tipo_usuario_id', 'Tipo')}}
                                {{Form::select('tipo_usuario_id', array(
                                    '1' => "Administrador",
                                    '2' => "Repartidor",
                                    '3' => "Usuario"), $tipo_usuario_id, array('class'=>'form-control'))}}
                            </div>
                            <div class="form-group col-xs-12">
                                {{Form::label('email', 'Email')}}
                                @if($action == "create")
                                    {{Form::text('email', null, array('class'=>'form-control'))}}
                                @else
                                    {{Form::text('email', null, array('class'=>'form-control', 'disabled'=>'disabled'))}}
                                @endif
                            </div>

                            @if($action == "create")
                                <div class="form-group col-xs-12 col-md-6">
                                    {{Form::label('password', 'Contraseña')}}
                                    {{Form::password('password', array('class'=>'form-control'))}}
                                </div>

                                <div class="form-group col-xs-12 col-md-6">
                                    {{Form::label('password_confirmation', 'Confirmar contraseña')}}
                                    {{Form::password('password_confirmation', array('class'=>'form-control'))}}
                                </div>
                            @endif
                            <div class="form-group col-xs-12">
                                {{Form::label('calle', 'Calle')}}
                                {{Form::text('calle', null, array('class'=>'form-control'))}}
                            </div>
                            <div class="form-group col-xs-12 col-md-6">
                                {{Form::label('colonia', 'Colonia')}}
                                {{Form::text('colonia', null, array('class'=>'form-control'))}}
                            </div>
                            <div class="form-group col-xs-6">
                                {{Form::label('codigo_postal', 'Código Postal')}}
                                {{Form::number('codigo_postal', null, array('class'=>'form-control'))}}
                            </div>
                            <div class="form-group col-xs-12">
                                {{Form::label('referencia', 'Referencias')}}
                                {{Form::textarea('referencia', null, array('class'=>'form-control', 'rows' => '2'))}}
                            </div>

                            <div class="form-group col-xs-12">
                                <div class="marco-imagen col-xs-12 text-center">
                                    @if(isset($user->imagen_usuario) || $user->imagen_usuario !="")
                                        <img src="{{url($user->imagen_usuario)}}" id="imagen-view" height="200"/>
                                    @else
                                        <img src="{{url('img/default.png')}}" height="200" id="imagen-view" />
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
    </div>


@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/css/fileinput.css')}}">

@endsection

@section('scripts')
    <script type="text/javascript" src="{{url("/js/fileinput.js")}}"></script>
    <script type="text/javascript" src="{{url("/js/dynamicImage.js")}}"></script>
    <script type="text/javascript" src="{{url("/js/userValidations.js")}}"></script>
@endsection
