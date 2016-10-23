    @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Nuevo Pedido
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <table class="table table-responsive">
                            <tr>
                                <th colspan="2">
                                    <h4>Ingrese el teléfono del cliente</h4>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        {{Form::label('telefono', 'Teléfono')}}
                                        {{Form::number('telefono', null, array('class'=>'form-control'))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" colspan="2">
                                    <img id="imagen_usuario" height="100" src="{{url('/img/default.png')}}" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        {{Form::label('nombre', 'Nombre')}}
                                        {{Form::text('nombre', null, array('class'=>'form-control'))}}
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        {{Form::label('email', 'Email')}}
                                        {{Form::text('email', null, array('class'=>'form-control'))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        {{Form::label('direccion', 'Dirección')}}
                                        {{Form::text('direccion', null, array('class'=>'form-control input-medium bfh-phone', 'data-country'=>'MX'))}}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        {{Form::label('referencia', 'Referencias')}}
                                        {{Form::textarea('referencia', null, array('rows'=>'2', 'class'=>'form-control input-medium bfh-phone', 'data-country'=>'MX'))}}
                                    </div>
                                </td>
                            </tr>


                        </table>


                        <div id="map" style="height:400px"></div>

                        <h4>Seleccione los Productos</h4>
                        <div class="form-group">
                            <div class="col-xs-5 selectContainer">
                                <select class="form-control" name="size">
                                    <option value="">Escriba el nombre del producto</option>
                                    @foreach($productos as $producto)
                                        <option value="{{$producto->id}}">{{$producto->nombre}} - ${{number_format($producto->precio,2)}}</option>
                                    @endforeach
                                </select>
                                @foreach($productos as $producto)
                                    <input type="hidden" id="{{$producto->id}}_nombre" value="{{$producto->nombre}}">
                                    <input type="hidden" id="{{$producto->id}}_precio" value="{{$producto->precio}}">
                                @endforeach
                            </div>
                        </div>

                        <table class="table" id="table-productos">
                            <tr id="header">
                                <th></th>
                                <th>Cantidad</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Importe</th>
                            </tr>

                        </table>
                    </div>
                    <div class="panel-footer text-right">
                        <button id="generar_pedido" class="btn btn-primary">Continuar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{url('/js/bootstrap-combobox.js')}}"></script>
    <!-- Latest compiled and minified JavaScript -->

    <script>
        var map;
        function initMap() {
            var myLatLng = {
                lat: 26.909069,
                lng: -101.421252
            };
            getLocation();
            // Create a map object and specify the DOM element for display.
            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                scrollwheel: false,
                zoom: 14
            });

            $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
            //do something onclick
                    .click(function(){
                        var that=$(this);
                        if(!that.data('win')){
                            that.data('win',new google.maps.InfoWindow({content:'this is the center'}));

                        }
                    });

        };

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);

            } else {
            }
        }

        function showPosition(position) {

            console.log("SHWQOH");
            console.log( position.coords.latitude)
            console.log( position.coords.longitude);
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBm7WFeq4Oa1M9sL6HQ9NZbIxdibgSEEOE&callback=initMap"
            async defer></script>

    <script>
        var xhr;
        var xhr2;
        var productos = [];
        $(function(){
            $("select").combobox();

            $("select").on('change', function(){
                addProduct(this.value);
            });


            $("#telefono").on('change keyup pase', function(){

                //Se cancela la búsqueda si hay una activa.
                if(xhr){
                    xhr.abort();
                }
                xhr = $.ajax({
                    url: "{{url('/usuario/by_phone')}}",
                    data: {
                        telefono: $("#telefono").val()
                    },
                    method:"post",
                    success: function (data) {
                        console.log(data);
                        if(data.user) {
                            console.log("SHWIOT")
                            //IMAGEN
                            $("#nombre").val(data.user.nombre).prop("disabled", true);
                            $("#email").val(data.user.email).prop("disabled", true);
                            $("#referencia").val(data.user.referencia)
                            if(data.ultimo_pedido)
                                $("#direccion").val(data.ultimo_pedido.direccion).change();
                            else
                                $("#direccion").val(data.user.calle + ", " + data.user.colonia).change();

                            if(data.user.imagen_usuario)
                                $("#imagen_usuario").attr("src","{{url("/")}}" + data.user.imagen_usuario).change();
                            else
                                $("#imagen_usuario").attr("src","{{url('/img/default.png')}}");
                        }
                        else{
                            console.log("WOWOWOW0");
                            $("#nombre").val("").prop("disabled", false);
                            $("#email").val("").prop("disabled", false).change();
                            $("#direccion").val("");
                            $("#referencia").val("");
                            $("#imagen_usuario").attr("src","{{url('/img/default.png')}}");
                            map.panTo({
                                lat: 26.909069,
                                lng: -101.421252
                            });
                        }
                    }
                });
            });

            $("#direccion").on('change paste keyup', function(){
                //Se cancela la búsqueda si hay una activa.
                if(xhr2){
                    xhr2.abort();
                }
                xhr2 = $.ajax({
                    url: "http://maps.google.com/maps/api/geocode/json",
                    data: {
                        address: $("#direccion").val()
                    },
                    method:"get",
                    success: function (data) {
                        if(data.results[0]) {
                            map.panTo(data.results[0].geometry.location)
                        }
                        else{
                            map.panTo({
                                lat: 26.909069,
                                lng: -101.421252
                            });
                        }
                    }
                });
            });

            $("#generar_pedido").on('click', function(){
                $.ajax({
                    url: "{{url('/pedidos/generar')}}",
                    data: {
                        telefono: $("#telefono").val(),
                        nombre: $("#nombre").val(),
                        email: $("#email").val(),
                        referencia: $("#referencia").val(),
                        lat: map.getCenter().lat(),
                        lng: map.getCenter().lng(),
                        direccion: $("#direccion").val(),
                        productos: productos
                    },
                    method:"post",
                    success: function (data) {
                        console.log(data);
                    }
                });
            })

        });

        function addProduct(id){
                if($("#table-productos").find("#"+id).length != 0){
                    //SHOW SNACKBAR
                }
                else{
                    productos.push({
                        cantidad: 1,
                        id: id,
                    });

                    $("#table-productos").append('<tr id="'+id+'">'+
                        '<td class="col-xs-1"><a href="" class="btn btn-danger">X</a></td>'+
                        '<td class="col-xs-1"><input class="form-control" id="'+id+'_cantidad" type="number" value=1 min=1></td>'+
                        '<td class="col-xs-6">'+$("#"+id+"_nombre").val()+'</td>'+
                        '<td class="col-xs-2">$'+$("#"+id+"_precio").val()+'</td>'+
                        '<td class="col-xs-2" id="'+id+'_total"></td>'+
                        '</tr>'
                    );
                    var importe = Number($('#'+id+'_cantidad').val()) * Number($("#"+id+"_precio").val());
                    $('#'+id+'_total').html("$"+ importe.toFixed())
                    $("#"+id+"_cantidad").on('change keyup paste', function(){
                        var importe = Number($('#'+id+'_cantidad').val()) * Number($("#"+id+"_precio").val());
                        $('#'+id+'_total').html("$"+ importe.toFixed());
                    });

                }
        }
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/css/bootstrap-combobox.css')}}">
    <link rel="stylesheet" href="{{url('/css/marker.css')}}">

@endsection