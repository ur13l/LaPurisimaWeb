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

                            @include('promociones.nueva')
                            @include('promociones.activas')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section ('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">
    <link rel="stylesheet" href="{{url('css/circlecrop.css')}}">
    <link rel="stylesheet" href="{{url('css/bootstrap-datepicker.min.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

@section ('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tablasPromociones.js')}}"></script>
    <script type="text/javascript" src="{{url('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="{{url('js/selects.js')}}"></script>
    <script src="{{url('js/promociones.js')}}"></script>
    <script src="{{url('js/validations.js')}}"></script>
    <script src="{{url('js/promoValidations.js')}}"></script>
@endsection
