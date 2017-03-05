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

/**
 * Función que nos devuelve si un campo tiene un valor mayor a x y menor y
 * @param elem
 * @returns {boolean}
 */
function numeroEntre(elem, min, max){
    if(elem.val() < min || elem.val() > max){
        setError(elem, "El valor debe ser mayor a " + min + (max?"y menor o igual a "+ max:""));
        return false;
    }
    return true;
}

/**
 * Función para comprobar la validez del campo de teléfono
 * @param elem
 * @returns {boolean}
 */
function esTelefonoValido(elem){
    //Se confirma que el teléfono esté en un formato válido
    var num = elem.val();
    var mob=/^[+]*[(]{0,1}[0-9]{1,3}[)]{0,1}[-\s\./0-9]*$/g;
    if (!mob.test(num)) {
        setError( elem, 'El teléfono introducido no es válido');
        return false;
    }
    return true
}


/**
 * Método que comprueba la validez del campo email.
 * @param elem
 * @returns {boolean}
 */
function esEmailValido(elem){
    var email = elem.val();
    var exp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    if(!exp.test(email)) {
        setError(elem, "El email introducido no es válido");
        return false;
    }
    return true;
}

/**
 * Comprueba la validez de un password (mayor a 6 caracteres)
 * @param elem
 * @returns {boolean}
 */
function esPasswordValido(elem){
    if(elem.val().length <= 5 && elem.val().length > 0){
        setError(elem, "La contraseña debe contar con un mínimo de seis caracteres")
        return false;
    }
    return true;
}

/**
 * Comprueba que las contraseñas colocadas coincidan
 * @param elem1
 * @param elem2
 * @returns {boolean}
 */
function confirmPassword(elem1, elem2){
    if(elem1.val() != elem2.val()){
        setError(elem2, "Las contraseñas no coinciden");
        return false;
    }
    return true;
}


/**
 * Método para declarar un error en un elemento de bootstrap.
 * @param elem
 * @param msg
 */
function setError(elem, msg){
    //Se limpia el elemento por si existe algún error previo
    elem.parent().removeClass("has-error");
    elem.siblings(".text-danger").remove();

    //Se genera el nuevo error.
    elem.parent().addClass("has-error")
    elem.after('<span class="text-danger">'+msg+'</span>');

    //Se coloca un nuevo evento para limpiar los campos una vez que sus valores han cambiado
    elem.change(function(){
        elem.parent().removeClass("has-error");
        elem.siblings(".text-danger").remove();
    })
}