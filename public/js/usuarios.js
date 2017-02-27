$(function(){
    $(document).on( 'click', ".btn-eliminar",function(){
        var self = this;
        var nombre = $(this).parent().siblings('.nombre').html();
        $(".modal-message").html(`¿Está seguro que desea eliminar al usuario <strong>${nombre}</strong>? 
            <br> Este cambio no puede ser deshecho.`);
        $("#modal-eliminar").modal();
        $("#btn-si").attr('href', 'usuarios/eliminar/' + $(self).data('id'));
    });
});