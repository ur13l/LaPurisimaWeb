$(function(){
    $("#form-promo-usuario").submit(function(){
        selectUsuarioV = !esInputVacio($("#u_select-usuario"))
        limiteUsosV = validacionLimUsos("u");
        descuentoPrecioV = validacionDescPrecio($("input[name=descuentoRadio]:checked"), $("#u_descuentoPrecioInput"));
        descuentoPorcV = validacionDescPorc($("input[name=descuentoRadio]:checked"), $("#u_descuentoPorcInput"));
        productoV = validProductos();

        if(selectUsuarioV && limiteUsosV && descuentoPorcV && descuentoPrecioV && productoV)
            return true;
        return false;
    });

    $("#form-promo-producto").submit(function(){
        selectProductoV = !esInputVacio($("#p_select-producto"))
        limiteUsosV = validacionLimUsos("p");
        descuentoPrecioV = validacionDescPrecio($("input[name=descuentoRadio]:checked"), $("#p_descuentoPrecioInput"));
        descuentoPorcV = validacionDescPorc($("input[name=descuentoRadio]:checked"), $("#p_descuentoPorcInput"));


        if(selectProductoV && limiteUsosV && descuentoPorcV && descuentoPrecioV)
            return true;
        return false;
    });


    $("#form-promo-general").submit(function(){
        limiteUsosV = validacionLimUsos("g");
        descuentoPrecioV = validacionDescPrecio($("input[name=descuentoRadio]:checked"), $("#p_descuentoPrecioInput"));
        descuentoPorcV = validacionDescPorc($("input[name=descuentoRadio]:checked"), $("#p_descuentoPorcInput"));


        if(limiteUsosV && descuentoPorcV && descuentoPrecioV)
            return true;
        return false;
    });
});


    function validacionLimUsos(o){
        $chk = $(`#${o}_limiteChk`);
        $num = $(`#${o}_limiteNum`);

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