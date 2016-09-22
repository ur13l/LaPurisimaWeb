
@foreach($repartidores as $index => $repartidor)
    @if($index >= 4)
        <?php $display = 'none'; ?>
    @else
        <?php $display = 'inline-block'; ?>
    @endif

    <div class="col-xs-3" id="repartidor{{$index}}" style="padding:10px;  margin-left:14px; cursor: pointer; display:{{$display}}">
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