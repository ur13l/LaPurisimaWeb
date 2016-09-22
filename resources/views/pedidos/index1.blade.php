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

    <script id="details-template" type="text/x-handlebars-template">
        <table class="table">
            <tr>
                <td>Full name:</td>
                <td></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td></td>
            </tr>
            <tr>
                <td>Extra info:</td>
                <td>And any further details here (images etc)...</td>
            </tr>
        </table>
    </script>
@endsection


@section ('styles')
    <link rel="stylesheet" href="css/tables.css">
@section ('scripts')
    <script type="text/javascript">
        var template = Handlebars.compile($("#details-template").html());

        var table = $('#table-pendientes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('/pedidos/data')}}",
            columns: [
                {
                    "className":      'details-control',
                    "orderable":      false,
                    "searchable":     true,
                    "data":           null,
                    "defaultContent": ''
                },

                {data: 'cliente.nombre', name: 'cliente.nombre'},
                {data: 'direccion', name: 'direccion'},
                {data: 'fecha', name: 'fecha'},
                {data: 'total', name: 'total'}
            ],
            order: []
        });

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
                row.child( template(row.data()) ).show();
                tr.addClass('shown');
            }
        });
    </script>
@endsection
