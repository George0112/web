<!doctype html>
<html lang="{{ app()->getLocale() }}">
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/video.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Do Hyeon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gugi">
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <script src='fb.js'></script>
  </head>

  <body>
    <!-- Navbar -->
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
                  <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">partI <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="#">item1</a></li>
                      <li><a href="#">item2</a></li>
                      <li><a href="#">item3</a></li>
                      <li><a href="#">item4</a></li>
                    </ul>
                  </li>
                  <li><a href='./video.html'>partII</a></li>
                  <li><a href='#partIII'>partIII</a></li>
                  <li class="part-icon"><i class="fas fa-user"></i></li>
                  <li class="part-icon"><i class="fas fa-flag"></i></i></li>
                  <li class="part-icon"><i class="fas fa-envelope"></i></li>
                  <li class="part-icon">  <i class="fas fa-check-square"></i></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Content -->
    <div class='container'>
      <div class='row'>
        <h1 class="videoTitle">Listening</h1>
        <div id='playScreen' class='col col-md-6 col-lg-6'>
          <div id='player'></div>
          <div class='below' id='below'>
            <div id='underSubtitles'></div>
            <div id='lngChangeLabel'>
              <a id='eng_caption' href="javascript::" onclick="captionLgnFunc('eng')">
                英
              </a>
              <a id='cn_caption' href="javascript::" onclick="captionLgnFunc('cn')">
                中
              </a>
            </div>
            <div class="checkbox">
              <label>
                <span id='repeatText'>Repeat</span><input type="checkbox" data-toggle="toggle" id="repeatToggle">
              </label>
            </div>
            <div
              class="fb-like"
              data-share="true"
              data-width="100%"
              data-show-faces="true">
            </div>
          </div>
        </div>
        <div class='col col-md-6 col-lg-6 col-sm-12'>
          <ol class='list-group control-time' id='subtitle'></ol>
        </div>
      </div>
      <div class='row'>
        <div class='col col-md-12 col-lg-12 col-sm-12'>
          <div class="fb-comments" data-href="http://140.114.79.72" data-width="880" data-numposts="5"></div>
        </div>
      </div>
    </div>
    <!-- Script -->
    <script>
    var videoPlays = {!! $videoPlays !!};
</script>
    <script src="./scripts/scriptP.js"></script>
  </body>

</html>
