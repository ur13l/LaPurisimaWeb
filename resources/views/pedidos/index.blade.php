@extends('layouts.app')

@section('content')
    <div class="container">

        {{Form::hidden('csrf_token' , csrf_token(), array('id' => 'csrf_token'))}}
        {{Form::hidden('_url' , url('/'), array('id' => '_url'))}}
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="panel panel-default text-center" style="padding-bottom:15px">
                    <div class="panel-body ">Registra un nuevo pedido</div>
                    <a href="{{url('/pedidos/nuevo')}}" class="btn btn-primary">Continuar</a>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Pedidos Pendientes
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="col-xs-12">
                            <table id="table-pendientes" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Status</th>
                                    <th>Usuario</th>
                                    <th>Direccion</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Pedidos En Camino
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-xs-10 col-xs-offset-1">
                            <h4>Pedidos en camino</h4>
                            <table id="table-asignados" class="table table-striped  table-hover  dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Fecha</th>
                                    <th>Status</th>
                                    <th>Usuario</th>
                                    <th>Direccion</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section ('styles')
    <link rel="stylesheet" href="{{url('css/tables.css')}}">
@endsection
@section ('scripts')
    <script type="text/javascript" src="{{url('js/moment-with-locales.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tables.js')}}"></script>
    <script type="text/javascript" src="{{url('js/tablasPedidos.js')}}"></script>

        <script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.0.0/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/4.0.0/firebase-messaging.js"></script>

        <script>
          // Initialize Firebase
          var config = {
            apiKey: "AIzaSyAjGz9ssE5_rnubqRzf06xqr02C2Y2wEbg",
            authDomain: "lapurisima-162004.firebaseapp.com",
            databaseURL: "https://lapurisima-162004.firebaseio.com",
            projectId: "lapurisima-162004",
            storageBucket: "lapurisima-162004.appspot.com",
            messagingSenderId: "684650354150"
          };
          firebase.initializeApp(config);

          const messaging = firebase.messaging();

          messaging.requestPermission()
            .then(function() {
              console.log('Notification permission granted.');
              // TODO(developer): Retrieve an Instance ID token for use with FCM.
              // ...
              return messaging.getToken()

            })
            .catch(function(err) {
              console.log('Unable to get permission to notify.', err);
            });


          // Get Instance ID token. Initially this makes a network call, once retrieved
          // subsequent calls to getToken will return from cache.
          messaging.getToken()
          .then(function(currentToken) {
            if (currentToken) {
              sendTokenToServer(currentToken);
            } else {
              // Show permission request.
              console.log('No Instance ID token available. Request permission to generate one.');
              // Show permission UI.
              //setTokenSentToServer(false);
            }
          })
          .catch(function(err) {
            console.log('An error occurred while retrieving token. ', err);
            //showToken('Error retrieving Instance ID token. ', err);
            //setTokenSentToServer(false);
          });

          // Callback fired if Instance ID token is updated.
      messaging.onTokenRefresh(function() {
        messaging.getToken()
        .then(function(refreshedToken) {
          console.log('Token refreshed.');
          // Indicate that the new Instance ID token has not yet been sent to the
          // app server.
          //setTokenSentToServer(false);
          // Send Instance ID token to app server.
          sendTokenToServer(refreshedToken);
          // ...
        })
        .catch(function(err) {
          console.log('Unable to retrieve refreshed token ', err);
          //showToken('Unable to retrieve refreshed token ', err);
        });
      });

          function sendTokenToServer(token) {
            $.ajax({
              url: '{{url('/token/register')}}',
              method: 'POST',
              data: {
                token: token,
                _token: $("[name=_token]").val()
              },
              success: function (data) {
                console.log(data);
              }
            })
          }
        </script>
@endsection
