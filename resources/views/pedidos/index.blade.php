@extends('layouts.app')

@section('content')
    <div class="container">

        {{Form::hidden('csrf_token' , csrf_token(), array('id' => 'csrf_token'))}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default text-center" style="padding-bottom:15px">
                    <div class="panel-body ">Registra un nuevo pedido</div>
                    <a href="{{url('/pedidos/nuevo')}}" class="btn btn-primary">Continuar</a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Pedidos Pendientes
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="col-xs-12">
                            <table id="table-pendientes" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Status</th>
                                    <th>Usuario</th>
                                    <th>Direccion</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Pedidos En Camino
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-xs-10 col-xs-offset-1">
                            <h4>Pedidos en camino</h4>
                            <table id="table-asignados" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Status</th>
                                    <th>Usuario</th>
                                    <th>Direccion</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section ('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">
@endsection
@section ('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tablasPedidos.js')}}"></script>
@endsection
