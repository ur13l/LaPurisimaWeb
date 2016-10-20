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
                                    <img height="100" src="{{url('/img/default.png')}}" alt="">
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

                            <tr class="text-right">
                                <td colspan="2">
                                    <button class="btn btn-default">Guardar datos de usuario</button>
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
                lat: Number("0"),
                lng: Number("0")
            };

            // Create a map object and specify the DOM element for display.
            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                scrollwheel: false,
                zoom: 14
            });

            marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: 'Hello World!'
            });
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


            $("#telefono").on('change keydown pase', function(){
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
                        $("#nombre").val(data.nombre);
                        $("#email").val(data.email);
                        $("#direccion").val(data.calle +", "+ data.colonia);
                    }
                });
            });

            $("#direccion").on('change paste keydown', function(){
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
                        console.log(data.results[0].geometry.location);
                        map.panTo(data.results[0].geometry.location)
                    }
                });
            });
        });

        function addProduct(id){
            console.log($("#table-productos").find("#"+id).length);
                if($("#table-productos").find("#"+id).length != 0){
                    //SHOW SNACKBAR
                }
                else{
                    productos.push({
                        cantidad: 1,
                        id: id,
                    });
                    $("#table-productos").append('<tr id="'+id+'">'+
                        '<th class="danger">X</th>'+
                        '<th><input class="form-control" id="'+id+'_cantidad" type="number" value=1 min=1></th>'+
                        '<th>'+$("#"+id+"_nombre").val()+'</th>'+
                        '<th>$'+$("#"+id+"_precio").val()+'</th>'+
                        '<th>$00</th>'+
                        '</tr>'
                    )
                }
        }
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/css/bootstrap-combobox.css')}}">

@endsection