$(function(){
    $("#form-usuario").submit(function(){

        var nombreVal = esInputVacio($("#nombre"));
        var telefonoVal = esTelefonoValido($("#telefono"));
        var emailVal = esEmailValido($("#email"));
        var passObl = esInputVacio($("#password"));
        var pass6 = esPasswordValido($("#password"));
        var confirmedPass = confirmPassword($("#password"), $("#password_confirmation"));

        if(!nombreVal && telefonoVal && emailVal && !passObl && pass6 && confirmedPass)
            return true;
        return false;
    })
});

