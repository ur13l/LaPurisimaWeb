$(function(){


    var tablaRepartidores = $("#table-repartidores").DataTable(generarTablaUsuario("repartidores"));
    var tablaClientes= $("#table-clientes").DataTable(generarTablaUsuario("clientes"));
    var tablaAdministradores = $("#table-administradores").DataTable(generarTablaUsuario("administradores "));


});