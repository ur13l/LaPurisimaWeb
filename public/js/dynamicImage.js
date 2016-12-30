$(function(){

    $("#imagen").on('change',function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#imagen-view")
                    .error(() => $("#imagen-view").attr( "src", "../../img/default_product.gif" ))
                    .attr('src', e.target.result)
                    .attr('height', 200);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#url-input").on('change keyup paste', function(){
        var self = this;
        $("#imagen-view")
            //.error(() => $("#imagen-view").attr( "src", "../../img/default_product.gif" ))
            .attr('src', $(self).val())
            .attr('height', 200);
    });

    $("#tab-url").click(function(){
        $("#imagen").fileinput('clear');
        $("#imagen-view")
            .attr('src', "../../img/default_product.gif" )
            .attr('height', 200);
    });

    $("#tab-archivo").click(function(){
        $("#url-input").val('');
        $("#imagen-view")
            .attr('src', "../../img/default_product.gif" )
            .attr('height', 200);
    })
})