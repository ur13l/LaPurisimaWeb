/**
 * Uriel Infante
 * Archivo para definir las funciones del dataTables en la vista de Promociones.
 */

$(function(){
    var tablaPromociones = $("#table-promociones").DataTable(generarTablaPromociones("promo"));
});

