$(function(){
    $("#form-usuario").submit(function(){

        var nombreVal = esInputVacio($("#nombre"));
        var emailVal = esInputVacio($("#email"));
        var telefonoVal = esTelefonoValido($("#telefono"));
        return false;
    })
});

/**
 * Función que nos devuelve si un campo está vacío, imprime mensaje en interfaz
 * @param elem
 * @returns {boolean}
 */
function esInputVacio(elem){
    if(elem.val() == "" || elem.val() == null || typeof elem.val() == "undefined"){
        setError(elem, "Este campo es obligatorio");
        return true;
    }
    return false;
}

function esTelefonoValido(elem){
    //Se confirma que el teléfono esté en un formato válido
    var num = elem.val();
    var mob=/^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
    if (!mob.test(num)) {
       elem.parent().addClass('has-error');
        elem.after('<span>El teléfono introducido no es válido</span>');
        return false;
    }
    return true
}


function setError(elem, msg){
    elem.parent().addClass("has-error")
    elem.after('<span>'+msg+'</span>');
}