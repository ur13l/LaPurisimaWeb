$(function(){
  $("#agregar-producto").click(function() {
    var selectedProduct = $("#productos-select").val();
    //Indica que se seleccionó un producto de la lista
    if(selectedProduct) {
      $("#empty-stock").parent().hide();
      //Si existe un registo con el mismo id
      if ($("#table-stock").find(`.hidden-id[value=${selectedProduct}]`).length > 0) {
        console.log("LOL");
      }
      //En caso de que no existan registros del producto en la tabla, se agrega el elemento.
      else {
        var imagen = $("#"+selectedProduct+"_imagen").val(),
          nombre = $("#"+selectedProduct+"_nombre").val()
          precio =Number($("#"+selectedProduct+"_precio").val());

        $("#table-stock > tbody").append( `
          <tr>
            <td><img src="${imagen}" height="70"> <input type="hidden" class="hidden-id" value="${selectedProduct}"></td>
            <td>${nombre}</td>
            <td>$${precio.toFixed(2)}</td>
            <td><input class="cantidad form-control text-center" type="number" name="" value="1"></td>
          </tr>
        `)
      }
    }
  });

  $("#guardar").click(function() {
    var array = [];
    $("#table-stock > tbody > tr").each(function(index, val) {
      if($(val).find("#empty-stock").length == 0) {
        array.push({
          id: $(val).find('.hidden-id').val(),
          cantidad: $(val).find('.cantidad').val()
        });
      }
    });

    $("input").prop('disabled', true);
    $.ajax({
      url: $("#_url").val() +"/usuarios/stock/actualizar",
      data: {
        id: $("#_id").val(),
        productos: array,
        _token: $("[name=_token]").val()
      },
      method: "POST",
      success: function (data) {
        if( data.success ) {
          $("input").prop('disabled', false);
          location.href=$("#_url").val() + "/usuarios";
        }
        else {
          displayErrors ( data.errors );
          $("input").prop('disabled', false);
        }
      }
    })
  });

});

function displayErrors (errors) {
  $("#errors").empty();
  for(var i = 0; i < errors.length; i++) {
    $("#errors").append(`
      <div class="alert alert-danger">
        ${errors[i]}
      </div>
    `);

  }
}
