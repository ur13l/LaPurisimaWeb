/**
 * Created by marioalbertonegreterodriguez on 03/03/17.
 * Validation for Reportes/index
 */
//Checks your telephone if it exists an user you get the information and use button else you can't continue.
var tel =false;
$(".telefono").on('change keyup pase', function(){
    var xhr;
    var telefono = $(this);
    if( telefono.val() == ""){
      //  $(".firstReport").prop( "disabled", false );
    // $(telefono.parent()).parent().next().find(".firstReport").prop( "disabled", false );
    //
    }
    //Se cancela la búsqueda si hay una activa.
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: "../public/usuario/by_phone",
        data: {
            telefono: telefono.val()
        },
        method:"post",
        success: function (data) {
            console.log(data);
            if(data.user) {
                //$(".nombre").html(data.user.nombre);
                $(telefono.parent()).parent().next().find(".nombre").html(data.user.nombre);
                //$(".invisibleid").val(data.user.id);
                $(telefono.parent()).find(".invisibleid").val(data.user.id);
                tel = true;
                $(telefono.parent()).parent().next().find(".firstReport").prop( "disabled", false );
            }
            else{
                $(telefono.parent()).parent().next().find(".nombre").html("No se encuentra el repartidor");
                if( telefono.val() == ""){
                  $(telefono.parent()).parent().next().find(".nombre").html(" ");
                }
                tel = false;
                $(telefono.parent()).find(".invisibleid").val("x");
            }
        }
    });
});
