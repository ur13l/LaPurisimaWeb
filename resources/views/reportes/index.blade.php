@extends('layouts.app')

@section('content')

        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                <div class="panel-heading">
                Reporte Productos cargados por repartidor
                  </div>
                <div class="panel-body">
                  @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif
          <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
        </div>
      </div>
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
                  Reporte Entregado a clientes por repartidor
            </div>
          <div class="panel-body">
            <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
          </div>
        </div>
        <div class="col-md-10 col-md-offset-1">
          <div class="panel panel-default">
            <div class="panel-heading">
                  Reporte  Regresado a bodega por repartidor
              </div>
            <div class="panel-body">
              <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
            </div>
          </div>
          <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading">
                  Reporte  Producto entregado a clientes
                </div>
              <div class="panel-body">
                <a href="{{url('/reportes/generar')}}"><button type="button" class="btn btn-primary">Generar</button></a></div>
              </div>
            </div>




    </div>
  </div>
</div>

@endsection

@section('styles')
  <link rel="stylesheet" href="/css/fileinput.css">

@endsection



@section('scripts')
<!--<script type="text/javascript" src="/js/fileinput.js"></script>-->
  <script type="text/javascript">
  function myFunction() {
    alert("hila");
  }
  </script>
@endsection
