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
                        <select class="selectpicker" data-live-search="true">
                            <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                            <option data-tokens="mustard">Burger, Shake and a Smile</option>
                            <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                        </select>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{url('/js/bootstrap-formhelpers.js')}}"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/i18n/defaults-*.min.js"></script>

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
        $(function(){
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
        })
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/css/bootstrap-formhelpers.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">

@endsection