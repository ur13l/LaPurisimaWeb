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
                            <table id="table-pendientes" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
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

@section ('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript">
        var template = function (d, tipo){
            var list = "";
            for(var i = 0 ; i < d.detalles.length; i++){
                list += '<tr>'+
                        '<td>'+d.detalles[i].cantidad+'</td>'+
                        '<td>'+d.detalles[i].producto.nombre+'</td>'+
                        '<td>$'+ (d.detalles[i].producto.precio * d.detalles[i].cantidad).toFixed(2)+'</td>'+
                '</tr>';
            }

            return '<div class="row slider '+tipo+'">'+
                    '<div class="col-xs-12 col-md-8" >'+
                    '<h4>Detalle de pedido</h4>' +
                    '<table class="table table-bordered">'+
                    '<thead>'+
                    '<th>Cantidad</th>'+
                    '<th>Producto</th>'+
                    '<th>Precio</th>'+
                    '</thead>'+
                    '<tbody>'+
                    list+
                    '</tbody>'+
                    '</table>'+
                    '</div>'+
                    '<div class="col-xs-12 col-md-4" style="padding:22px">'+
                    '<span><b>Total:</b> $'+d.total+'</span><br>'+
                    '<span><b>Fecha:</b> '+moment(d.fecha).format('DD/MM/YYYY')+'</span><br>'+
                    '<span><b>Hora:</b> '+moment(d.fecha).format('HH:mm')+'</span><br>'+
                    '<a href="{{url('/pedidos')}}/'+d.id+'" class="btn btn-primary col-xs-12">Asignar Conductor</a><br><br>'+
                    '<a href="{{url('/pedidos')}}/'+d.id+'" class="btn btn-danger col-xs-12">Cancelar</a>'+
                    '</div>'+
                    '</div>';
        };

        var tablePendientes = $('#table-pendientes').DataTable(generarTabla('solicitados'));
        addTableEvents( $('#table-pendientes tbody'), tablePendientes, 'solicitados')


        //TABLA DE ASIGNADOS
        var tableAsignados = $('#table-asignados').DataTable(generarTabla('asignados'));
        addTableEvents($('#table-asignados tbody'), tableAsignados, 'asignados')


        //

        function rotateArrow($elem, from, to){
            $({deg: from}).animate({deg: to}, {
                duration: 200,
                step: function(now) {
                    $elem.css({
                        transform: 'rotate(' + now + 'deg)'
                    });
                }
            });
        }

        function addTableEvents(elemTable, table, tipo){
            // Add event listener for opening and closing details
            elemTable.on('click', 'td.details-control-' + tipo, function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                table.rows().every( function () {
                    var r = this;
                    if(row.index() != r.index()) {
                        $('.' +tipo +'.slider', r.child()).slideUp(function () {
                            r.child.hide();
                        });
                        if(r.child.isShown()){
                            $elem = $($(".img-"+tipo)[r.index()]);
                            rotateArrow($elem, 90, 0);
                        }
                    }
                } );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    $('.' +tipo +'.slider', row.child()).slideUp(function () {
                        row.child.hide();
                        tr.removeClass('shown');
                    } );
                    var $elem = $($(".img-"+ tipo)[row.index()]);
                    rotateArrow($elem, 90,0);
                }
                else {
                    // Open this row
                    row.child( template(row.data(), tipo), 'no-padding'  ).show();
                    tr.addClass('shown');
                    $('.' +tipo +'.slider', row.child()).slideDown();
                    var $elem = $($(".img-"+ tipo)[row.index()]);
                    rotateArrow($elem, 0, 90);
                }
            });
        }
        function generarTabla(tipo){
            return {
                processing: true,
                serverSide: true,
                ajax: "{{url('/pedidos/')}}/" + tipo,
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
                },
                bLengthChange: false,
                columns: [
                    {
                        "className":      'details-control-'+tipo,
                        "orderable":      false,
                        "searchable":     true,
                        "data":           null,
                        "defaultContent": '<img class="img-'+tipo+'" src="/img/arrow-open.png" height="16">'
                    },

                    {data: 'fecha', name: 'fecha',"className":'details-control-' + tipo,
                        "orderable":      false,
                        "searchable":     true,
                        "defaultContent": '-',
                        "render": function ( data, type, full, meta ) {
                            fecha = moment(data).format('DD/MM/YYYY');
                            if(fecha != "Invalid date")
                                return fecha;
                            else
                                return "-";
                        }},
                    {data: 'cliente.nombre', name: 'cliente.nombre',"className":'details-control-' + tipo,
                        "orderable":      false,
                        "searchable":     true},
                    {data: 'direccion', name: 'direccion',"className":'details-control-' + tipo,
                        "orderable":      false,
                        "searchable":     true},
                    {data: 'total', name: 'total',"className":'details-control-' + tipo,
                        "orderable":      false,
                        "searchable":     true,
                        "render": function(data, type, full, meta){
                            if(data)
                                return "$" + data.toFixed(2);
                            else return data;
                        }}
                ],
                order: []
            }
        }
    </script>
@endsection
