
@foreach($repartidores as $index => $repartidor)
    @if($index >= 4)
        <?php $display = 'none'; ?>
    @else
        <?php $display = 'inline-block'; ?>
    @endif

    <div class="col-xs-3" id="repartidor{{$index}}" style="padding:10px; display:{{$display}}">
        <div class="panel panel-default repartidor-container" style="cursor:pointer;">
            {{Form::hidden('',$repartidor->user_id, ['class' => 'repartidor-id'])}}
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
