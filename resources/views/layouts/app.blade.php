<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>La Purísima</title>

    <link rel="manifest" href="{{url('/manifest.json')}}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/css/bootstrap-horizon.css')}}">
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    @yield('styles')

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    {{csrf_field()}}
    <nav class="navbar navbar-default navbar-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    La Purísima
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    @if (Auth::user())
                      @if (Auth::user()->tipo_usuario_id == 1)
                        <li><a href="{{ url('/productos') }}">Productos</a></li>
                      @endif
                      @if (Auth::user()->tipo_usuario_id == 1 || Auth::user()->tipo_usuario_id == 2)
                          <li><a href="{{ url('/pedidos') }}">Pedidos</a></li>
                      @endif
                      @if (Auth::user()->tipo_usuario_id == 1)
                          <li><a href="{{ url('/usuarios') }}">Usuarios</a></li>
                      @endif
                      @if (Auth::user()->tipo_usuario_id == 1)
                          <li><a href="{{ url('/promociones') }}">Promociones</a></li>
                      @endif
                      @if (Auth::user()->tipo_usuario_id == 1)
                          <li><a href="{{ url('/reportes') }}">Reportes</a></li>
                      @endif
                      @if (Auth::user()->tipo_usuario_id == 1)
                          <li><a href="{{ url('/graficas') }}">Gráficas</a></li>
                      @endif
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Iniciar sesión</a></li>
                        <li><a href="{{ url('/register') }}">Registrar</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->nombre }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Cerrar sesión</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/datatables.min.js"></script>
    <script type="text/javascript" src="{{url('/js/handlebars-v4.0.5.js')}}"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    @yield('scripts')

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

</body>
</html>
