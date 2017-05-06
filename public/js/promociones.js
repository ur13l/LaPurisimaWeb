$(function(){
    $(".limiteChk").change(function(){
        var checked = $(this).prop('checked');
        if(checked){
            $(this).siblings('.limiteNum').prop('disabled', false)
            $(this).siblings('.limiteNum').val('')
        }
        else{
            $(this).siblings('.limiteNum').prop('disabled', true)
            $(this).siblings('.limiteNum').val('')
        }
    });

    $('input[type=radio][name^=descuentoRadio]').change(function() {
        console.log(this.value)
        if (this.value == 'descuentoPrecio' || this.value == 'descuentoPrecio1') {
            $(".form-group-descuento-precio").removeClass("hide");
            $(".form-group-descuento-porcentaje").addClass("hide");
            $("[name=descuentoRadio][value=descuentoPrecio]").prop('checked', 'checked');
            $("[name=descuentoRadio1][value=descuentoPrecio1]").prop('checked', 'checked');
        }
        else {
            $(".form-group-descuento-porcentaje").removeClass("hide");
            $(".form-group-descuento-precio").addClass("hide");
            $("[name=descuentoRadio][value=descuentoPorcentaje]").prop('checked', 'checked');
            $("[name=descuentoRadio1][value=descuentoPorcentaje1]").prop('checked', 'checked');
        }


        //$(this).val("");
    });


})