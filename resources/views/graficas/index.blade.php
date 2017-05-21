@extends('layouts.app')

@section('content')

        <div class="container">
          <div class="row">
            <div class="col-md-10 col-md-offset-1">
              <div class="panel panel-default">
                <div class="panel-heading">
                Ventas totales del año
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

                  <div style="width: 90%;">
            <canvas id="lineChart" width="600" height="400"></canvas>
                   </div>
        </div>
      </div>
            </div>
    </div>
  </div>

  <!--<div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
          Ventas totales del año
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

            <div style="width: 90%;">
     <canvas id="lineChart2" width="600" height="400"></canvas>
             </div>
  </div>
</div>
      </div>
</div>
</div>
</div>-->


<script>
 var totales = [@foreach($totales as $k => $total)
   '{{ $total}}',
@endforeach]

</script>
@endsection

@section('styles')
  <link rel="stylesheet" href="/css/fileinput.css">

@endsection



@section('scripts')
<!--<script type="text/javascript" src="/js/fileinput.js"></script>-->
<script src="{{url('/js/chart.min.js')}}"></script>
<script src="{{url('/js/charts.js')}}"></script>
@endsection
