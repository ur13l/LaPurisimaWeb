@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-6">
              Productos
            </div>
            <div class="col-md-6 text-right">
              <a href="{{url('/producto/nuevo')}}"><button type="button" class="btn btn-primary">Nuevo</button></a></div>
            </div>
          </div>

        <div class="panel-body">
          @if(isset($message))
            <div class="alert alert-info info">
              @if($message == 'create')
                Producto guardado con éxito.
              @elseif ($message == 'update')
                Producto actualizado con éxito.
              @elseif ($message == 'delete')
                Producto eliminado.
              @endif
            </div>
          @endif
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Contenido</th>
                <th>Precio</th>
                <th>Editar</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($productos as $producto)
                <tr>
                  <td>{{$producto->nombre}}</td>
                  <td>{{$producto->stock}}</td>
                  <td>
                    @if ($producto->contenido >= 1000)
                      {{$producto->contenido / 1000}} L
                    @else
                      {{$producto->contenido}} ml
                    @endif
                  </td>
                  <td> $ {{number_format($producto->precio, 2)}}</td>
                  <td> <a href="{{url('/producto/editar?id='. $producto->id)}}">Editar</a></td>
                  <td> <a href="{{url('/producto/eliminar?id='. $producto->id)}}">Eliminar</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>
              <div class="text-right">
                  {{$productos->links()}}
              </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section ('scripts')
  <script type="text/javascript">
    $(function(){
      if($('.info')){
        $('.info').delay(5000).fadeOut();
      }
    });
  </script>
@endsection
