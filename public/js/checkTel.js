/**
 * Created by marioalbertonegreterodriguez on 03/03/17.
 *
 */
//Checks your telephone if it exists an user you get the information and use button else you can't continue.
var tel =false;
var tel1 = false;
var tel2 = false;
var tel3 = false;
$("#telefono").on('change keyup pase', function(){
    var xhr;
    if($("#telefono").val() == ""){
        $(".firstReport").prop( "disabled", false );
    }
    //Se cancela la búsqueda si hay una activa.
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: "../public/usuario/by_phone",
        data: {
            telefono: $("#telefono").val()
        },
        method:"post",
        success: function (data) {
            console.log(data);
            if(data.user) {
                $(".nombre").html(data.user.nombre);
                $(".invisibleid").val(data.user.id);
                tel = true;
                $(".firstReport").prop( "disabled", false );
            }
            else{
                $(".nombre").html("No se encuentra el repartidor");
                tel = false;
                $(".invisibleid").val("x");
            }
        }
    });
});


$("#telefono").on('change keyup pase', function(){
    var xhr;
    if($("#telefono").val() == ""){
        $(".firstReport").prop( "disabled", false );
    }
    //Se cancela la búsqueda si hay una activa.
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: "../public/usuario/by_phone",
        data: {
            telefono: $("#telefono").val()
        },
        method:"post",
        success: function (data) {
            console.log(data);
            if(data.user) {
                $(".nombre").html(data.user.nombre);
                $(".invisibleid").val(data.user.id);
                tel1 = true;
                $(".firstReport").prop( "disabled", false );
            }
            else{
                $(".nombre").html("No se encuentra el repartidor");
                tel1 = false;
                $(".invisibleid").val("x");
            }
        }
    });
});



$("#telefono").on('change keyup pase', function(){
    var xhr;
    if($("#telefono").val() == ""){
        $(".firstReport").prop( "disabled", false );
    }
    //Se cancela la búsqueda si hay una activa.
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: "../public/usuario/by_phone",
        data: {
            telefono: $("#telefono").val()
        },
        method:"post",
        success: function (data) {
            console.log(data);
            if(data.user) {
                $(".nombre").html(data.user.nombre);
                $(".invisibleid").val(data.user.id);
                tel2 = true;
                $(".firstReport").prop( "disabled", false );
            }
            else{
                $(".nombre").html("No se encuentra el repartidor");
                tel2 = false;
                $(".invisibleid").val("x");
            }
        }
    });
});


$("#telefono").on('change keyup pase', function(){
    var xhr;
    if($("#telefono").val() == ""){
        $(".firstReport").prop( "disabled", false );
    }
    //Se cancela la búsqueda si hay una activa.
    if(xhr){
        xhr.abort();
    }
    xhr = $.ajax({
        url: "../public/usuario/by_phone",
        data: {
            telefono: $("#telefono").val()
        },
        method:"post",
        success: function (data) {
            console.log(data);
            if(data.user) {
                $(".nombre").html(data.user.nombre);
                $(".invisibleid").val(data.user.id);
                tel3 = true;
                $(".firstReport").prop( "disabled", false );
            }
            else{
                $(".nombre").html("No se encuentra el repartidor");
                tel3 = false;
                $(".invisibleid").val("x");
            }
        }
    });
});
/*
$(".firstReport").on('click keyup pase', function(){
   if (tel || $("#telefono").val() == ""){
       $(".firstReport").prop( "disabled", false );
   }else{
       $(".firstReport").prop( "disabled", true);
   }
})*/