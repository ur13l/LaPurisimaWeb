@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Nuevo Pedido
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group col-xs-12 col-md-4">
                            {{Form::label('telefono', 'Teléfono')}}
                            {{Form::text('telefono', null, array('class'=>'form-control input-medium bfh-phone', 'data-country'=>'MX'))}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{url('/js/bootstrap-formhelpers.js')}}"></script>
      
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/css/bootstrap-formhelpers.css')}}">
@endsection