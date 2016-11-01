@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Usuarios
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{url('/producto/nuevo')}}"><button type="button" class="btn btn-primary">Nuevo</button></a></div>
                        </div>
                    </div>

                    <div class="panel-body">

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
