$(function() {

    var tablaProductos = $('#table-productos').DataTable(generarTablaProductos("prod"));
    addTableEvents($('#table-productos tbody'), tablaProductos, 'prod')

});

