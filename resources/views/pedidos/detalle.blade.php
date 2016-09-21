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
                                        <td>${{number_format($pedido->total, 2)}}</td>
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
                                                <span style="color:red">Cancelador</span>
                                            @elseif($pedido->status == 6)
                                                <span style="color:rebeccapurple">Fallido</span>
                                            @endif

                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <h4>Datos del usuario</h4>
                                <table class="table ">
                                    <tbody>
                                    <tr>
                                        <td class="text-center" colspan="2"><img height="100" src="{{url("/".$pedido->cliente->imagen_usuario)}}" alt=""></td>
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        <td>{{$pedido->cliente->nombre}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{$pedido->cliente->email}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12">
                                <h4>Detalles de pedido</h4>
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
                                                <td><img src="{{url('/'.$detalle->producto->imagen)}}" height="50" alt=""></td>
                                                <td>{{$detalle->cantidad}}</td>
                                                <td>{{$detalle->producto->nombre}}</td>
                                                <td>${{number_format($detalle->producto->precio,2)}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan="3">Total</th>
                                            <td>${{number_format($pedido->total,2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-xs-12">

                                @if($pedido->status == 1)
                                    <h4>Asignar repartidor</h4>
                                    <div class="repartidores">
                                        <div class="row search-repartidores">
                                            <div class="col-xs-4 col-md-2">
                                                <img class="picture" src="#" height="100">
                                            </div>
                                            <div class="col-xs-4 col-md-6">
                                                <p id="repartidor-definido-nombre">Conductor no asignado</p>
                                                <p id="repartidor-definido-src">Conductor no asignado</p>
                                            </div>
                                            <div class="col-xs-4">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" id="buscar-repartidores">
                                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div> <div class="content-loading" style="display: none;"></div>
                                        <div class="row row-horizon repartidores-container"  style="overflow: hidden; white-space:nowrap;">
                                            @foreach($repartidores as $index => $repartidor)
                                                @if($index >= 4)
                                                    <?php $display = 'none'; ?>
                                                @else
                                                    <?php $display = 'inline-block'; ?>
                                                @endif

                                                <div class="col-xs-3" id="repartidor{{$index}}" style="padding:10px; margin-left:14px; display:{{$display}}">
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
                                @else
                                    <h4>Detalles del repartidor</h4>
                                    <img class="picture" src="{{url($pedido->cliente->imagen_usuario)}}" height="200">
                                    {{$pedido->cliente->nombre}}
                                @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <img class="picture" src="https://maps.googleapis.com/maps/api/staticmap?center={{$pedido->latitud}},{{$pedido->longitud}}&markers={{$pedido->latitud}},{{$pedido->longitud}}&zoom=15&size=600x200&key=AIzaSyBm7WFeq4Oa1M9sL6HQ9NZbIxdibgSEEOE" height="200">
                                <div>{{$pedido->direccion}}</div>
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

        $(document).ready(function()
        {
            $(".picture").error(function(){
                console.log("w");
                $(this).attr('src', '{{url('/img/default.png')}}');
            });

            $("#right-repartidor").on('click',function(){
                $("#repartidor" + firstPosition).addClass('hide-slide');
                $("#repartidor" + (firstPosition+1)).addClass('hide-slide');
                $("#repartidor" + (firstPosition+2)).addClass('hide-slide');
                $("#repartidor" + (firstPosition+3)).addClass('hide-slide');
                $("#repartidor" + (firstPosition+4)).addClass('show-slide');
                $("#repartidor" + (firstPosition+5)).addClass('show-slide');
                $("#repartidor" + (firstPosition+6)).addClass('show-slide');
                $("#repartidor" + (firstPosition+7)).addClass('show-slide');
                firstPosition+=4;
                animation("-", "+");
            });

            $("#left-repartidor").on('click',function(){
                $("#repartidor" + firstPosition).addClass('hide-slide');
                $("#repartidor" + (firstPosition+1)).addClass('hide-slide');
                $("#repartidor" + (firstPosition+2)).addClass('hide-slide');
                $("#repartidor" + (firstPosition+3)).addClass('hide-slide');
                $("#repartidor" + (firstPosition-1)).addClass('show-slide');
                $("#repartidor" + (firstPosition-2)).addClass('show-slide');
                $("#repartidor" + (firstPosition-3)).addClass('show-slide');
                $("#repartidor" + (firstPosition-4)).addClass('show-slide');
                firstPosition-=4;
                animation("+","-");
            });

            $(".repartidor-container").on('click', function(){
                var nombre = $($(this).find(".repartidor-nombre")).html();
                var src = $($(this).find(".repartidor-imagen")).attr('src');
                $("#repartidor-definido-nombre").html(nombre);
                $("#repartidor-definido-src").html(src);
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
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{url('/css/pedidos.css')}}">
@endsection