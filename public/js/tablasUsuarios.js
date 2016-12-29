$(function(){


    var tablaRepartidores = $("#table-repartidores").DataTable(generarTablaUsuario("repartidores"));
    var tablaClientes= $("#table-clientes").DataTable(generarTablaUsuario("clientes"));
    var tablaAdministradores = $("#table-administradores").DataTable(generarTablaUsuario("administradores "));


    addEvents(tablaRepartidores, $("#table-repartidores"));
    addEvents(tablaClientes, $("#table-clientes"));
    addEvents(tablaAdministradores, $("#table-administradores"));
});


/**
 * Función para asignar los eventos de click a las tablas de usuario.
 * @param table
 */
function addEvents(table, tableDOM){
    tableDOM.on('click', 'tr', function () {
        var data = table.row( this ).data();
        window.location.href = "usuarios/" + data.id;
    } );
}