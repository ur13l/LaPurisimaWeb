$(function(){
    var tablaHistorialPedidos = $("#table-historial-pedidos").DataTable(generarTablaPedidos("historial-pedidos"));
    var tablaHistorialEnvios = $("#table-historial-envios").DataTable(generarTablaPedidos("historial-envios"));

    addTableEvents( $('#table-historial-pedidos tbody'), tablaHistorialPedidos, 'historial-pedidos');
    addTableEvents( $('#table-historial-envios tbody'), tablaHistorialEnvios, 'historial-envios');
})