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
                      {{$producto->contenido / 1000}} l.
                    @else
                      {{$producto->contenido}} ml.
                    @endif
                  </td>
                  <td> $ {{$producto->precio}}</td>
                  <td> <a href="/producto/editar?id={{$producto->id }}">Editar</a></td>
                  <td> <a href="{{url('/producto/eliminar')}}">Eliminar</a></td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
