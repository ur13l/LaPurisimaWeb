$(function(){
    $('.select-usuario').select2({
        multiple:true,
        ajax: {
            url: $("#_url").val() + "/usuario/search",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 30) < data.total
                    }
                };
            },

        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 2,
        templateResult: function(user){
            console.log(user);
            if(user.loading){
                return "Buscando...";
            }
            return `<table>
                        <tr>
                            <td rowspan="3"><img style="margin-right: 10px;" src="${user.imagen_usuario}" height="48px" width="48    px" class="img-circle" alt=""></td>
                            <td>${user.nombre}</td>
                        </tr>
                        <tr>
                            <td><small style="color:gray">${user.email}</small></td>
                        </tr>
                        <tr>
                            <td><small style="color:gray">${user.telefono}</small></td>
                        </tr>
                    </table>`;
        },
        templateSelection: function (user) {
            return user.nombre;;
        }

    });

    $('.select-producto').select2({
        multiple:true,
        ajax: {
            url: $("#_url").val() + "/producto/search",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 30) < data.total
                    }
                };
            },

        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 2,
        templateResult: function(producto){
            if(producto.loading){
                return "Buscando...";
            }
            return `<table>
                        <tr>
                            <td rowspan="3"><img style="margin-right: 10px;" src="${producto.imagen}" height="48px" width="48    px" class="img-circle" alt=""></td>
                            <td>${producto.nombre}</td>
                        </tr>
                        <tr>
                            <td><small style="color:gray">$${producto.precio}</small></td>
                        </tr>
                        <tr>
                            <td><small style="color:gray">${producto.contenido/1000}L.</small></td>
                        </tr>
                    </table>`;
        },
        templateSelection: function (producto) {
            return producto.nombre;;
        }

    });

    $(".fecha").datepicker({
        startDate: new Date().toDateString()
    })
})
