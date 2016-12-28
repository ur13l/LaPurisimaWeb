$(function(){
    $("#form-producto").submit(function(){

        var nombreVal = !esInputVacio($("#nombre"));
        var stockVal = !esInputVacio($("#stock"));
        var contenidoVal = !esInputVacio($("#contenido"));
        var precioVal = !esInputVacio($("#precio"));
        if(nombreVal && stockVal && contenidoVal && precioVal)
            return true;
        return false;
    })
});