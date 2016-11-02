$(function(){


    var tablePendientes = $('#table-pendientes').DataTable(generarTablaPedidos('solicitados'));
    addTableEvents( $('#table-pendientes tbody'), tablePendientes, 'solicitados')


//TABLA DE ASIGNADOS
    var tableAsignados = $('#table-asignados').DataTable(generarTablaPedidos('asignados'));
    addTableEvents($('#table-asignados tbody'), tableAsignados, 'asignados')

});