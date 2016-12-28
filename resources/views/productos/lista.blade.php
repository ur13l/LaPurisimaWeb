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
              {{Form::hidden('_url', url("/"), ['id' => '_url'])}}
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
          <table id="table-productos" class="table table-striped table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
            <thead>
              <tr>
                <th></th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Contenido</th>
                <th>Precio</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
          </table>
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

  <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
  <script src="{{url('/js/tablaProductos.js')}}"></script>
@endsection
