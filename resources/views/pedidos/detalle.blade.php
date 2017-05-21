@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Información del Pedido
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(isset($messages))
                            <div class="alert alert-danger danger">
                                @if($messages == 'no.stock')
                                    El repartidor no cuenta con stock suficiente.
                                @endif
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <h4>Pedido No. {{$pedido->id}}</h4>
                                <table class="table ">
                                    <tbody>
                                    <tr>
                                        <th>Fecha</th>
                                        <td>{{$pedido->fecha->format('d/m/Y ')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Hora</th>
                                        <td>{{$pedido->fecha->format('H:i:s')}}</td>
                                    </tr>
                                    <tr>
                                        <th>Dirección de envío</th>
                                        <td>{{$pedido->direccion}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <?php $des1 = 0?>
                                    @foreach($pedido->detallesDescuento as $detalle)
                                        <?php $des1 += $detalle->descuento * $detalle->cantidad?>
                                    @endforeach
                                        <td>${{number_format($pedido->total - $des1, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <th>Estatus del pedido</th>
                                        <td>
                                            @if($pedido->status == 1)
                                                <span style="color:rebeccapurple">Solicitado</span>
                                            @elseif($pedido->status == 2)
                                                <span style="color:cornflowerblue">Asignado</span>
                                            @elseif($pedido->status == 3)
                                                <span style="color:darkolivegreen">En camino</span>
                                            @elseif($pedido->status == 4)
                                                <span style="color:green">Entregado</span>
                                            @elseif($pedido->status == 5)
                                                <span style="color:red">Cancelado</span>
                                            @elseif($pedido->status == 6)
                                                <span style="color:rebeccapurple">Fallido</span>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tipo de pago</th>
                                        <td>
                                            {{$pedido->tipo_pago_id == 1 ? "Efectivo" : "Tarjeta de crédito/débito"}}
                                        </td>
                                    </tr>
                                    @if($pedido->tipo_pago_id == 1 && $pedido->cantidad_pago > 0)
                                        <tr>
                                            <th>Pago con</th>
                                            <td>
                                                ${{number_format($pedido->cantidad_pago, 2)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Cambio</th>
                                            <td>
                                                ${{number_format($pedido->cantidad_pago - ($pedido->total - $des1), 2)}}
                                            </td>
                                        </tr>
                                    @endif
                                    @if($pedido->status != 4 && $pedido->status != 5 && $pedido->status != 6)
                                        <tr>
                                            <th>Cancelar Pedido</th>
                                            <td>
                                                <form action="{{url('/pedidos/cancelar')}}" method="POST">
                                                    <input type="hidden" value="{{$pedido->id}}" name="id_pedido">
                                                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                                                    <input type="hidden" value="detalle" name="view">
                                                    <input type="submit" class="btn btn-danger col-xs-12" value="Cancelar">
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h4>Datos del usuario</h4>
                                <table class="table ">
                                    <tbody>
                                    <tr>
                                        <td cladss="text-center" colspan="2"><img height="100" src="{{$pedido->cliente->imagen_usuario}}" alt=""></td>
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        <td>{{$pedido->cliente->nombre}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{$pedido->cliente->email}}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            <a href="{{url('/pedidos')}}" class="btn btn-info col-xs-12" > Regresar a pedidos</a>
                                        </th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <h4>Detalles de pedido</h4>
                                @if($pedido->status != 6)
                                <table class="table table-striped">
                                    <thead>
                                        <th>Imagen</th>
                                        <th>Cant.</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                    </thead>
                                    <tbody>
                                        @foreach($pedido->detalles as $detalle)
                                            <tr>
                                                <td><img src="{{$detalle->producto->imagen}}" height="50" alt=""></td>
                                                <td>{{$detalle->cantidad}}</td>
                                                <td>{{$detalle->producto->nombre}}</td>
                                                <td>${{number_format($detalle->producto->precio * $detalle->cantidad,2)}}</td>
                                            </tr>
                                        @endforeach
                                        <?php $des = 0?>
                                        @foreach($pedido->detallesDescuento as $detalle)

                                            @for($i = 0 ; $i < $detalle->cantidad; $i++)
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>{{$detalle->desc->descripcion}}</td>
                                                    <td style="color:green">- ${{number_format($detalle->descuento)}}</td>
                                                </tr>
                                            @endfor

                                            <?php $des += $detalle->descuento * $detalle->cantidad?>
                                        @endforeach
                                        <tr>
                                            <th colspan="3">Total</th>
                                            <td>${{number_format($pedido->total - $des,2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                @else
                                    <div class="panel text-center">
                                        <p>Pedido fallido.</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-xs-12">

                                @if($pedido->status == 1)
                                    <h4>Asignar repartidor</h4>
                                    <div class="repartidores">
                                        <div class="row search-repartidores">
                                            <div class="col-xs-4 col-md-3">
                                                <img class="picture repartidor-definido-imagen" src="#" height="100">
                                            </div>
                                            {{Form::open(array('url' => '/pedidos/asignar'))}}
                                            {{Form::hidden('repartidor-definido-id', "", array('id' => 'repartidor-definido-id'))}}
                                            {{Form::hidden('pedido-id', $pedido->id, array('id' => 'pedido-id'))}}
                                            <div class="col-xs-4 col-md-5">
                                                <p id="repartidor-definido-nombre">Conductor no asignado</p>
                                                <p id="repartidor-definido-email"></p>
                                                <p id="repartidor-definido-telefono"></p>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" id="buscar-repartidores">
                                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                                </div>
                                                <div class="form-group">
                                                    {{Form::submit('Asignar', array('class'=>'form-control btn btn-primary'))}}
                                                </div>
                                                <div></div>
                                            </div>

                                            {{Form::close()}}
                                        </div> <div class="content-loading" style="display: none;"></div>
                                        <div class="row row-horizon repartidores-container"  style="overflow: hidden; text-align:center; white-space:nowrap;">
                                            @foreach($repartidores as $index => $repartidor)
                                                @if($index >= 4)
                                                    <?php $display = 'none'; ?>
                                                @else
                                                    <?php $display = 'inline-block'; ?>
                                                @endif

                                                <div class="col-xs-3" id="repartidor{{$index}}" style="padding:10px; display:{{$display}}">
                                                    <div class="panel panel-default repartidor-container" style="cursor:pointer;">
                                                        {{Form::hidden('',$repartidor->id, ['class' => 'repartidor-id'])}}
                                                        <div class="row">
                                                            <div class="text-center col-xs-5">
                                                                <img class="picture repartidor-imagen" src="{{url($repartidor->imagen_usuario . '')}}" height="50">
                                                            </div>
                                                            <div class="text-center col-xs-7" style="padding-top:20px">
                                                                <i class="glyphicon glyphicon-star"></i>
                                                                <span class="repartidor-calificacion">{{$repartidor->calificacion}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class=" text-center col-xs-12">
                                                                <h5 class="repartidor-nombre">{{$repartidor->nombre}}</h5>
                                                                <input type="hidden" class="repartidor-email" value="{{$repartidor->email}}">
                                                                <input type="hidden" class="repartidor-telefono" value="{{$repartidor->telefono}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="left-repartidor"><img src="{{url('/img/previous.png')}}" height="32" alt=""></div>
                                        <div id="right-repartidor"><img src="{{url('/img/next.png')}}" height="32" alt=""></div>
                                        </div>
                                    </div>
                                @elseif(isset($pedido->repartidor))
                                    <h4>Datos del repartidor</h4>
                                    <table class="table ">
                                        <tbody>
                                        <tr>
                                            <td class="text-center" colspan="2"><img height="100" src="{{url("/".$pedido->repartidor->imagen_usuario)}}" alt=""></td>
                                        </tr>
                                        <tr>
                                            <th>Nombre</th>
                                            <td>{{$pedido->repartidor->nombre}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{$pedido->repartidor->email}}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                @else
                                    <h4>Datos del repartidor</h4>
                                    <div class="panel text-center">
                                        <p>Repartidor no asignado</p>
                                    </div>

                                @endif

                            </div>
                        </div>
                        <div class="row col-xs-12">
                            <h4 >Ubicación</h4>
                            <div class="text-center">

                                @if($pedido->status == 1 || $pedido->status == 2 || $pedido->status == 3)
                                   <div id="map" style="height:400px"></div>
                                @elseif($pedido->status == 4 || $pedido->status == 5)
                                    <img class="picture" src="https://maps.googleapis.com/maps/api/staticmap?center={{$pedido->latitud}},{{$pedido->longitud}}&markers={{$pedido->latitud}},{{$pedido->longitud}}&zoom=14&size=600x200&key=AIzaSyBm7WFeq4Oa1M9sL6HQ9NZbIxdibgSEEOE" height="200">
                                @elseif($pedido->status == 6)
                                    <div class="panel text-center">
                                        <p>Ubicación desconocida</p>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        var firstPosition = 0;
        var xhr;
        var map = null;
        var markers = [];

        $(document).ready(function()
        {
            $(function(){
                if($('.danger')){
                    $('.danger').delay(5000).fadeOut();
                }
            });

            $(".picture").error(function(){
                console.log("w");
                $(this).attr('src', '{{url('/img/default.png')}}');
            });

            $("#right-repartidor").on('click',function(){

                var lastPosition = $(".repartidores-container").children().length - 1;

                if(firstPosition >= 0 && firstPosition < lastPosition-3) {
                    $("#repartidor" + firstPosition).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 1)).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 2)).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 3)).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 4)).addClass('show-slide');
                    $("#repartidor" + (firstPosition + 5)).addClass('show-slide');
                    $("#repartidor" + (firstPosition + 6)).addClass('show-slide');
                    $("#repartidor" + (firstPosition + 7)).addClass('show-slide');
                    firstPosition += 4;
                    animation("-", "+");
                }
            });

            $("#left-repartidor").on('click',function(){
                if(firstPosition < lastPosition-3 && firstPosition > 3) {
                    $("#repartidor" + firstPosition).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 1)).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 2)).addClass('hide-slide');
                    $("#repartidor" + (firstPosition + 3)).addClass('hide-slide');
                    $("#repartidor" + (firstPosition - 1)).addClass('show-slide');
                    $("#repartidor" + (firstPosition - 2)).addClass('show-slide');
                    $("#repartidor" + (firstPosition - 3)).addClass('show-slide');
                    $("#repartidor" + (firstPosition - 4)).addClass('show-slide');
                    firstPosition -= 4;
                    animation("+", "-");
                }
            });

            $(".repartidor-container").on('click', function(){
                var nombre = $($(this).find(".repartidor-nombre")).html();
                var email = $($(this).find(".repartidor-email")).val();
                var telefono = $($(this).find(".repartidor-telefono")).val();
                var src = $($(this).find(".repartidor-imagen")).attr('src');
                var id = $($(this).find(".repartidor-id")).val();
                $("#repartidor-definido-nombre").html(nombre);
                $("#repartidor-definido-email").html(email);
                $("#repartidor-definido-telefono").html(telefono);
                $(".repartidor-definido-imagen").attr('src', src);
                $("#repartidor-definido-id").val(id);
            });

            $("#buscar-repartidores").on("keyup paste",function(){
                //Se cancela la búsqueda si hay una activa.
                if(xhr){
                    xhr.abort();
                }

                //Mensaje de cargado
                $(".content-loading").show();

                //Se ocultan los repartidores
                $(".repartidores-container").hide();
                xhr = $.ajax({
                    url: "{{url('/pedidos/repartidores')}}",
                    data:{
                        search: $("#buscar-repartidores").val()
                    },
                    success:function(data){
                        firstPosition = 0;
                        if(data == "")
                            data = "<div style='height:128px; text-align:center'>No se encontraron registros</div>";
                        $(".repartidores-container").html(data);
                        $(".content-loading").hide();
                        $(".repartidores-container").show();
                    }
                });
            })
        });

        function animation(op1, op2){
            var side = $(".repartidores-container").width() -50;
            if(op1 == "+") {
                $(".show-slide, .hide-slide").animate({
                    left: "-=" + side + "px"
                }, 0);
            }
            $(".show-slide").show();
            $(".hide-slide, .show-slide").animate({
                left: op1+"=" + side + "px"
            }, function(){
                if(op1 != "+") {
                    $(".hide-slide, .show-slide").animate({
                        left: op2 + "=" + side + "px"
                    }, 0);
                }
                $(".hide-slide").hide();
                $(".show-slide").removeClass("show-slide");
                $(".hide-slide").removeClass("hide-slide");
            });

        }

        function removeMarkers(){
            var act = new Date();
            for(var i = markers.length - 1 ; i >= 0; i--){
                if (act - markers[i].updated_at > 10000){
                    markers[i].setMap(null);
                    markers.splice(i, 1);
                }
            }
        }

        function getInfoMarker(repartidor, assigned){
            var contentString = '<div id="content" style="width: 900" >'+
                    '<div class="col-xs-5">' +
                    '<img src="{{url("/")}}/'+repartidor.user.imagen_usuario+'" width="100" alt="">'+
                    '</div>'+
                    '<div class="col-xs-6">' +
                    '<h4>'+ repartidor.user.nombre+'</h4>';

                    if(!assigned) {
                        contentString += '<button class="btn btn-primary btnMap" id="' + repartidor.user.id + '" data-nombre-repartidor="' +
                                 repartidor.user.nombre + '" data-imagen-repartidor ="' + repartidor.user.imagen_usuario + '">Asignar</button>';
                    }

                    contentString+=  '</div>' +
                            '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 900
            });

            return infowindow;
        }

        function findWithAttr(array, attr, value) {
            for(var i = 0; i < array.length; i += 1) {
                if(array[i][attr] === value) {
                    return i;
                }
            }
            return -1;
        }


        function transition(marker, newPosition){
            var numDeltas = 100;
            var delay = 10; //milliseconds
            var i = 0;
            var deltaLat;
            var deltaLng;
            i = 0;
            deltaLat = (newPosition.lat() - marker.position.lat())/numDeltas;
            deltaLng = (newPosition.lng() - marker.position.lng())/numDeltas;
            moveMarker(marker, i, deltaLat, deltaLng, numDeltas, delay);
        }

        function moveMarker(marker, i, deltaLat, deltaLng, numDeltas, delay){
            var lat =   marker.position.lat() + deltaLat;
            var lng =   marker.position.lng() + deltaLng;
            //console.log(lat);
            //console.log(lng);
            var latlng = new google.maps.LatLng(lat, lng);
            marker.setPosition(latlng);
            if(i!=numDeltas){
                i++;
                setTimeout(function(){moveMarker(marker, i, deltaLat, deltaLng, numDeltas, delay)}, delay);
            }
        }

        </script>
    @if($pedido->status == 1 || $pedido->status == 2 || $pedido->status == 3)
        <script>
            function initMap() {
                var myLatLng = {
                    lat: Number("{{$pedido->latitud}}"),
                    lng: Number("{{$pedido->longitud}}")};

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
                showRepartidores();
                setInterval(showRepartidores, 5000);
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBm7WFeq4Oa1M9sL6HQ9NZbIxdibgSEEOE&callback=initMap"
                async defer></script>
    @endif
    @if($pedido->status == 1)
       <script>
             function showRepartidores(){

                   $.ajax({
                       url: "{{url('/pedidos/repartidores-json')}}",
                       data: {
                           latitud: Number("{{$pedido->latitud}}"),
                           longitud: Number("{{$pedido->longitud}}")
                       },
                       success: function (data) {
                           removeMarkers();
                           for(var i = 0 ; i < data.length; i++){

                               //Esto se ejecuta cuando el marcador ya existe en el mapa. Busca el que concuerda
                               //con la propiedad id.
                               var index = findWithAttr(markers, 'id', data[i].id);
                               if(index != -1){
                                   var newDestination =new google.maps.LatLng( data[i].latitud, data[i].longitud );
                                   markers[index].updated_at = new Date(); //Se actualiza la fecha, para que no se elimine.
                                   transition(markers[index], newDestination);
                               }
                               //En caso de que el marcador no exista, se genera uno nuevo.
                               else {
                                   var infoMarker = getInfoMarker(data[i]);
                                   var marker = new google.maps.Marker({
                                       position: {
                                           lat: data[i].latitud,
                                           lng: data[i].longitud
                                       },
                                       map: map,
                                       id: data[i].id,
                                       title: 'Hello World!',
                                       icon: '{{url("/img/repartidor.png")}}',
                                       updated_at: new Date()
                                   });
                                   google.maps.event.addListener(marker, 'click',(function(marker, i, infowindow) {
                                       return function() {
                                           infowindow.open(map, marker);
                                           $(".btnMap").on('click', function(e){
                                               $("#repartidor-definido-nombre").html(this.dataset.nombreRepartidor);
                                               $(".repartidor-definido-imagen").attr('src',"{{url("/")}}/"+ this.dataset.imagenRepartidor);
                                               $("#repartidor-definido-id").val(this.id);
                                           })
                                       }
                                   })(marker, i, infoMarker))
                                   markers.push(marker);
                               }
                           }

                       }
                   });
               }
       </script>


       @endif

        @if($pedido->status == 2 || $pedido->status == 3)
            <script>
                function showRepartidores(){
                    $.ajax({
                        url: "{{url('/pedidos/repartidor-pedido-json')}}",
                        data: {
                            id_pedido: "{{$pedido->id}}"
                        },
                        success: function (data) {
                            console.log(data);
                            removeMarkers();
                            for(var i = 0 ; i < data.length; i++){
                                //Esto se ejecuta cuando el marcador ya existe en el mapa. Busca el que concuerda
                                //con la propiedad id.
                                var index = findWithAttr(markers, 'id', data[i].id);
                                if(index != -1){
                                    var newDestination =new google.maps.LatLng( data[i].latitud, data[i].longitud );
                                    markers[index].updated_at = new Date(); //Se actualiza la fecha, para que no se elimine.
                                    transition(markers[index], newDestination);
                                }
                                //En caso de que el marcador no exista, se genera uno nuevo.
                                else {
                                    var infoMarker = getInfoMarker(data[i], true);
                                    var marker = new google.maps.Marker({
                                        position: {
                                            lat: data[i].latitud,
                                            lng: data[i].longitud
                                        },
                                        map: map,
                                        id: data[i].id,
                                        title: 'Hello World!',
                                        icon: '{{url("/img/repartidor.png")}}',
                                        updated_at: new Date()
                                    });
                                    google.maps.event.addListener(marker, 'click',(function(marker, i, infowindow) {
                                        return function() {
                                            infowindow.open(map, marker);

                                        }
                                    })(marker, i, infoMarker))
                                    markers.push(marker);
                                }
                            }

                        }
                    });
                }
            </script>
        @endif
@endsection

@section('styles')
   <link rel="stylesheet" href="{{url('/css/pedidos.css')}}">
@endsection