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
                            <div class="col-xs-12 col-md-5">
                                <h4>Detalles del pedido</h4>
                                <table class="table table-bordered">
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
                                            <th>Usuario</th>
                                            <td>{{$pedido->cliente->nombre}}</td>
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
                            <div class="col-xs-12 col-md-7">

                                @if($pedido->status == 1)
                                    <h4>Asignar repartidor</h4>
                                    <div class="repartidores">
                                        <div class="row search-repartidores">
                                            <div class="col-xs-4">
                                                <img class="picture" src="#" height="100">
                                            </div>
                                            <div class="col-xs-8">
                                                <div class="form-group has-feedback">
                                                    <input type="text" class="form-control" id="inputSuccess4">
                                                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row repartidores-content">
                                            @foreach($repartidores as $index => $repartidor)
                                                @if($index >= 3)
                                                    <?php $display = 'none'; ?>
                                                @else
                                                    <?php $display = 'inline-block'; ?>
                                                @endif

                                                <div class="col-xs-4" id="repartidor{{$index}}" style="padding:10px; display:{{$display}}">
                                                    <div class="panel panel-default">
                                                        <div class="row">
                                                            <div class="text-center col-xs-5">
                                                                <img class="picture" src="{{url($repartidor->imagen_usuario . '')}}" height="50">
                                                            </div>
                                                            <div class="text-center col-xs-7" style="padding-top:20px">
                                                                <i class="glyphicon glyphicon-star"></i>
                                                                <span>{{$repartidor->calificacion}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class=" text-center col-xs-12">
                                                                <h5>{{$repartidor->nombre}}</h5>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @endforeach
                                            <div id="left-repartidor">IZQ</div>
                                            <div id="right-repartidor">DER</div>
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
        var paginatePositionRepartidores = 1;

        $(document).ready(function()
        {
            $(".picture").error(function(){
                console.log("w");
                $(this).attr('src', '{{url('/img/default.png')}}');
            });

            $("#right-repartidor").on('click',function(){
                console.log("SHIT");
                $("#repartidor" + paginatePositionRepartidores).hide();
                $("#repartidor" + paginatePositionRepartidores-1).hide();
                $("#repartidor" + paginatePositionRepartidores+1).hide();
                $("#repartidor" + paginatePositionRepartidores+2).show();
                $("#repartidor" + paginatePositionRepartidores+3).show();
                $("#repartidor" + paginatePositionRepartidores+4).show();
                paginatePositionRepartidores+=3
            })
        });

        $(document).on('click', ".pagination a", function(e){
            e.preventDefault();
            var page =  this.href.split('?page=')[1];
            $.ajax({
                url: "{{url('/pedidos/repartidores')}}?page=" + page
            }).done(function(data){
                $(".repartidores-content").html(data);
                location.hash = page;
            });
        });
    </script>
@endsection