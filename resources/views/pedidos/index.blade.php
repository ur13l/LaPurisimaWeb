@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
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
                        <table id="table-pendientes" class="table table-striped  table-hover">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Direccion</th>
                                <th>Total</th>
                                <th>Cancelar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pedidosPendientes as $pedido)
                                    <tr class='clickable-row' data-href='#'>
                                        <td class="details-control">{{$pedido->cliente->nombre}}</td>
                                        <td class="details-control">{{$pedido->direccion}}</td>
                                        <td class="details-control">{{$pedido->fecha}}</td>
                                        <td class="details-control">{{$pedido->total}}</td>
                                        <td class="details-control">X</td>
                                    </tr>
                            @endforeach
                            </tbody>
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
                                Pedidos
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-xs-10 col-xs-offset-1">
                            <h4>Pedidos pendientes</h4>
                            <table class="table table-striped  table-hover">
                                <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Direccion</th>
                                    <th>Fecha</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($pedidosPendientes as $pedido)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
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
    <link rel="stylesheet" href="css/tables.css">
@section ('scripts')
    <script type="text/javascript">
        function format ( d ) {
            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                    '<tr>'+
                    '<td>Full name:</td>'+
                    '<td>'+d.name+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Extension number:</td>'+
                    '<td>'+d.extn+'</td>'+
                    '</tr>'+
                    '<tr>'+
                    '<td>Extra info:</td>'+
                    '<td>And any further details here (images etc)...</td>'+
                    '</tr>'+
                    '</table>';
        }

        $(function(){
            var table= $("#table-pendientes").DataTable( {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
                },
                "columnDefs": [
                    {
                        "orderable":false,
                        "targets": ["_all"]
                    }
                ],
                "sDom": '<"top">rt<"bottom"lp><"clear">',
                "order" : [],
                "bLengthChange": false //used to hide the property
            } );

            // Add event listener for opening and closing details
            $('#table-pendientes tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        });
    </script>
@endsection
