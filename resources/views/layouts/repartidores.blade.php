@foreach($repartidores as $repartidor)
    <h5>{{$repartidor->nombre}}</h5>
@endforeach
{{$repartidores->links()}}