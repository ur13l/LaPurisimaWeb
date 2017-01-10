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

    $('input[type=radio][name^=descuentoRadio]').change(function(){

        if(this.value == 'descuentoPrecio' && this.value == 'descuentoPrecio1'){
            $(".form-group-descuento-precio").removeClass("hide");
            $(".form-group-descuento-porcentaje").addClass("hide");
        }
        else{
            $(".form-group-descuento-porcentaje").removeClass("hide");
            $(".form-group-descuento-precio").addClass("hide");
        }
        //$(this).val("");
    });


})