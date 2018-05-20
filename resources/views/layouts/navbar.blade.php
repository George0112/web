<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Hot Video</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<!-- Material Design -->
    <link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="styles/navbar.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Do Hyeon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gugi">
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_TRACKING_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-43764481-1');
</script>
    @yield('style')
  </head>
  <body data-target="#navbar-spy" data-spy="scroll">

    <!--  navbar  -->
    <nav class="navbar navbar-inverse navbar-fixed-top" id='navb'>
        <div class="container-fluid vMiddle" id='navbar-spy'>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavigiator" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">
                    <i class="fas fa-video"></i>
                    Videos
                </a>
            </div>

            <div class="collapse navbar-collapse" id="myNavigiator">
                <ul class="nav navbar-nav navbar-right">
                    <li class="part">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Levels<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                        <li class="part"><a href="#">Basic : TOEIC 250-545</a></li>
                        <li class="part"><a href="#">Moderate : TOEIC 550-780</a></li>
                        <li class="part"><a href="#">Conversant : TOEIC 785-990</a></li>
                      </ul>
                    </li>
                    <li class="part"><a href='#partII'>Channels</a></li>
                    <li class="part"><a href='#partIII'>Listening & Speaking</a></li>
                    
                    <li class="part-icon"><a href='/insertVideo' class="member-item"><i class="fas fa-flag"></i></a></li>
                    <li class="part-icon"><a href='/editVideo' class="member-item"><i class="fas fa-envelope"></i></a></li>
                    <!--li class="part-icon">  <i class="fas fa-check-square"></i></li-->
                    <li class="part-icon">
                      <a href="#" class="dropdown-toggle member-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>
                      <ul class="dropdown-menu">
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="#" role="button"  aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                              
                            </li>
                        @endguest
                      </ul>
                      
                    </li>

                </ul>

            </div>
        </div>
    </nav>
    
    @yield('content')
    
    @yield('script')
    
    </body>

</html>
