$(function(){
    $("#form-promo-usuario").submit(function(){
        selectUsuarioV = !esInputVacio($("#u_select-usuario"))
        limiteUsosV = validacionLimUsos();
        descuentoPrecioV = validacionDescPrecio($("input[name=descuentoRadio]:checked"), $("#u_descuentoPrecioInput"));
        descuentoPorcV = validacionDescPorc($("input[name=descuentoRadio]:checked"), $("#u_descuentoPorcInput"));
        productoV = validProductos();

        if(selectUsuarioV && limiteUsosV && descuentoPorcV && descuentoPrecioV && productoV)
            return true;
        return false;
    })
});


function validacionLimUsos(){
    $chk = $("#u_limiteChk");
    $num = $("#u_limiteNum");

    if($chk.prop('checked')){
        return !esInputVacio($num);
    }
    else{
        return true;
    }
}

function validacionDescPrecio(radio, input){
    if(radio.val() == "descuentoPrecio"){
        return numeroEntre(input, 0);
    }
    return true;
}

function validacionDescPorc(radio, input){
    if(radio.val() == "descuentoPorcentaje"){
        return numeroEntre(input, 0, 100);
    }
    return true;
}

function validProductos() {
    if($("#u_select-producto").is(":visible")){
        return !esInputVacio($("#u_select-producto"));
    }
    return true;
}