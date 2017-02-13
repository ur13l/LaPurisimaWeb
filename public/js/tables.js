/**
 * Uriel Infante
 * Archivo en el que se muestra el código para generar las tablas utilizando Datatables en las interfaces de
 * usuarios, productos, pedidos y promociones.
 */

/**
 * Función que genera el template que se ve en el detalle de pedidos.
 * @param d
 * @param tipo
 * @returns {string}
 */
var template = function (d, tipo){
    var list = "";
    for(var i = 0 ; i < d.detalles.length; i++){
        list += '<tr>'+
            '<td>'+d.detalles[i].cantidad+'</td>'+
            '<td>'+d.detalles[i].producto.nombre+'</td>'+
            '<td>$'+ (d.detalles[i].producto.precio * d.detalles[i].cantidad).toFixed(2)+'</td>'+
            '</tr>';
    }
    console.log(d);
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
        ((d.status==1)?'<a href="pedidos/'+d.id+'" class="btn btn-primary col-xs-12">Asignar Conductor</a><br><br>':'<a href="pedidos/'+d.id+'" class="btn btn-primary col-xs-12">Ver detalles</a><br><br>') +
        '<form action="/pedidos/cancelar" method="POST">' +
        '<input type="hidden" value="'+d.id+'" name="id_pedido">' +
        '<input type="hidden" value="'+$("#csrf_token").val()+'" name="_token">' +
        '<input type="hidden" value="index" name="view">' +
        ((d.status!=4 && d.status!=5 && d.status!=6)?'<input type="submit" class="btn btn-danger col-xs-12" value="Cancelar">':'')+
        '</form>' +
        '</div>'+
        '</div>';
};

/**
 * Función auxiliar para generar la animación al desplegar el detalle de un pedido.
 * @param $elem
 * @param from
 * @param to
 */
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

/**
 * Se agregan los eventos necesarios en la generación de tabla de pedidos.
 * @param elemTable
 * @param table
 * @param tipo
 */
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

/**
 * Tabla generada para la codificación de una tabla en pedidos.
 * @param tipo
 * @returns {{processing: boolean, serverSide: boolean, ajax: {url: string, data: {id: (*|jQuery)}}, language: {url: string}, bLengthChange: boolean, columns: *[], order: Array}}
 */
function generarTablaPedidos(tipo){
    console.log($("#_url").val() + "/pedidos/" + tipo)
    return {
        processing: true,
        serverSide: true,
        ajax: {
            url: $("#_url").val() + "/pedidos/" + tipo,
            data: {
                "id": $("#_id").val()
            }
        },
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
                "defaultContent": '<img class="img-'+tipo+'" src="img/arrow-open.png" height="16">'
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
            {data: 'status', name: 'status',"className":'details-control-' + tipo,
                "orderable":      false,
                "searchable":     true,
                "defaultContent": '-',
                "render": function ( data, type, full, meta ) {
                    if(data == 1){
                        return '<span class="label label-default">Solicitado</span>';
                    }
                    else if(data == 2){
                        return '<span class="label label-primary">Asignado</span>';
                    }
                    else if(data == 3){
                        return '<span class="label label-info">En camino</span>';
                    }
                    else if(data == 4){
                        return '<span class="label label-success">Entregado</span>';
                    }
                    else if(data == 5){
                        return '<span class="label label-danger">Cancelado</span>';
                    }
                    else if(data == 6){
                        return '<span class="label label-warning">Fallido</span>';
                    }
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

/**
 * Generación de tabla de usuarios
 * @param tipo
 * @returns {{processing: boolean, serverSide: boolean, ajax: {url: string, type: string, headers: {X-CSRF-TOKEN: (*|jQuery)}}, language: {url: string}, bLengthChange: boolean, columns: *[], order: Array}}
 */
function generarTablaUsuario(tipo){
    var columnas = [
        {
            data: 'imagen_usuario', name: 'imagen_usuario', "className": 'details-control-' + tipo,
            "orderable":      false,
            "searchable":     true,
            "render": function(data, type, full, meta) {
              return '<img class="img-'+tipo+' img-circle" src="'+data+'" height="50" width="50" >'
            },
            "defaultContent": '<img class="img-'+tipo+' img-circle" src="img/default.png" height="48">'
        },

        {
            data: 'nombre', name: 'nombre', "className": 'nombre details-control-' + tipo,
            "orderable": false,
            "searchable": true,
            "defaultContent": '-'
        },
        {data: 'email', name: 'email',"className":'details-control-' + tipo,
            "orderable":      false,
            "searchable":     true},
        {data: 'telefono', name: 'telefono',"className":'details-control-' + tipo,
            "orderable":      false,
            "searchable":     true}
    ];

    if(tipo == "repartidores"){
        columnas.push({data: 'datos_repartidor.status', name: 'datos_repartidor.status',"className":'details-control-' + tipo,
            "orderable":      false,
            "searchable":     true,
            "render": function(data, type, full, meta){
                if(data == 1){
                    return '<span class="label label-success">Activo</span>'
                }
                else {
                    return '<span class="label label-default">Inactivo</span>';
                }
            }});
    }

    return {
        processing: true,
        serverSide: true,
        ajax: {
            'url': $("#_url").val() + "/usuarios/" + tipo,
            'type': 'POST',
            'headers': {
                'X-CSRF-TOKEN':  $("#csrf_token").val()
            }
        },
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        },
        bLengthChange: false,
        columns: columnas,
        order: []
    }
}


/**
 * Generación de la tabla de productos
 * @param tipo
 * @returns {{processing: boolean, serverSide: boolean, ajax: {url: string}, language: {url: string}, bLengthChange: boolean, columns: *[], order: Array}}
 */
function generarTablaProductos(tipo){
    var columnas = [
        {
            data: 'imagen', name: 'imagen', "className": 'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render": function(data, type, full, meta) {
                return '<img class="imagen img-circle" src="'+data+'" height="50" width="50">'
            },
            "defaultContent": '<img class="imagen" src="img/arrow-open.png" height="16">'
        },

        {
            data: 'nombre', name: 'nombre', "className": 'details-control-'+ tipo,
            "orderable": false,
            "searchable": true,
            "defaultContent": '-'
        },
        {data: 'stock', name: 'stock',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true},
        {data: 'contenido', name: 'contenido',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true},
        {data: 'precio', name: 'precio',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true},
        {data: 'id', name: 'editar',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render" : function(data){
                return `<a style="float:left;" href="producto/editar/${data}"}}">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a></td>`
            }
        },
        {data: 'id', name: 'elim',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render" : function(data){
                return `<a style="float:left;" href="producto/eliminar/${data}" class="close text-center center-block">&times</a></td>`
            }
        }
    ];


    return {
        processing: true,
        serverSide: true,
        ajax: {
            'url': $("#_url").val() + "/producto/table"
        },
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        },
        bLengthChange: false,
        columns: columnas,
        order: []
    }
}


/**
 * Generación de tabl de promociones.
 * @param tipo
 * @returns {{processing: boolean, serverSide: boolean, ajax: {url: string}, language: {url: string}, bLengthChange: boolean, columns: *[], order: Array}}
 */
function generarTablaPromociones(tipo){
    var columnas = [
        {
            data: 'user.nombre', name: 'user.nombre', "className": 'details-control-'+ tipo,
            "orderable": false,
            "searchable": true,
            "defaultContent": '<span class="label label-default">General</span>'
        },
        {data: 'producto.nombre', name: 'producto.nombre',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "defaultContent": '<span class="label label-default">General</span>'
        },
        {data: 'descuento', name: 'descuento',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render": data => {
                if(data == 0){
                    return '<span class="label label-primary">No aplica</span>'
                }
                return `$${data}`;
            }
        },
        {data: 'descuento_porcentaje', name: 'descuento_porcentaje',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render": data => {
                if(data == 0){
                    return '<span class="label label-primary">No aplica</span>'
                }
                return `${data}%`;
            }
        },
        {data: 'fecha_vencimiento', name: 'fecha_vencimiento',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render": data => {
                var f = moment(data).format('DD/MM/YYYY');
                if(f == "Invalid date"){
                    return '<span class="label label-success">Sin fecha límite</span>';
                }
                return f;
            }
        },
        {data: 'usos_restantes', name: 'usos_restantes',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "defaultContent": '<span class="label label-success">Sin límite</span>'
        },
        {data: 'id', name: 'editar',"className":'details-control-'+ tipo,
            "orderable":      false,
            "searchable":     true,
            "render" : function(data){
                return `<a style="float:left;" href="${$('#_url').val()}/promociones/eliminar/${data}" class="close text-center center-block">&times</a></td>`

            }
        },

    ];


    return {
        processing: true,
        serverSide: true,
        ajax: {
            'url': $("#_url").val() + "/promociones/table"
        },
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        },
        bLengthChange: false,
        columns: columnas,
        order: []
    }
}





