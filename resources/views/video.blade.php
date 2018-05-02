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
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Do Hyeon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gugi">
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
                        <li class="part"><a href="#">Basic：TOEIC 250-545</a></li>
                        <li class="part"><a href="#">Moderate：TOEIC 550-780</a></li>
                        <li class="part"><a href="#">Conversant：TOEIC 785-990</a></li>
                      </ul>
                    </li>
                    <li class="part"><a href='#partII'>Channels</a></li>
                    <li class="part"><a href='#partIII'>Listenin & Speaking</a></li>
                    <li class="part-icon"><a href='/videoList'><i class="fas fa-user"></a></i></li>
                    <li class="part-icon"><a href='/insertVideo'><i class="fas fa-flag"></a></i></i></li>
                    <li class="part-icon"><i class="fas fa-envelope"></i></li>
                    <li class="part-icon">  <i class="fas fa-check-square"></i></li>

                </ul>

            </div>
        </div>
    </nav>
    <!--background-->
    <div class = "toppage">
      <div class = "index-back"></div>
      <div class = "index-describe">
        用電影、音樂、脫口秀影片<br>
         輕鬆聽懂英語、說好英文
      </div>
      <div class = "index-input" id="indexInput">
        <input placeholder="我想找…熱門、TED、新聞的影片" class = "index-input-banner">
        <button class = "index-input-btn"><i class="fas fa-search"></i></button>
      </div>
    </div>

    <!--Thumbnail-->

    <div class = "row">
      <h1 class = "videopart">New Videos</h1>
      <div class = "col col-md-9">
        <div class = "videospan">

            <?php foreach($videos as $video){
            if($video->level=="Basic")
                $level="<a class='btn btn-black btn-tag'>Basic</a>";
            else if($video->level=="Intermediate")
                $level="<a class='btn btn-primary btn-tag'>Intermediate</a>";
            else
                $level="<a class='btn btn-black btn-tag'>Advance</a>";
            
            if($video->test==1)
                $test="<a class='btn btn-danger btn-tag'>測</a>";
            else
                 $test="";
            
            if($video->accent=='NULL')
                $accent="";
            else
                $accent="<a class='btn btn-warning btn-tag'>{$video->accent}</a>";
            echo "<div id='{$video->id}' class='col col-md-4 col-lg-3 frame'>
                <div class='thumbnail'>
                    <a href='./video?videoId={$video->videoId}'>
                        <div class='photo'>
                            <img src='http://img.youtube.com/vi/{$video->videoId}/0.jpg'>
                            <span class='label photolabel label-inverse'>
                                <span class='video-time'>{$video->time}</span>
                            </span>
                        </div>
                    </a>
                    <div class='caption'>
                        <a href='./video?videoId={$video->videoId}' class='title'>
                            <h3 class='title'>{$video->title}</h3>
                        </a>
                        <p>
                            {$level}
                            {$accent}
                            {$test}
                        </p>
                    </div>
                </div>
            </div>";
          }
          echo "$videos" ;
          ?>
        </div>
        
      </div>
      <div class = "col col-md-3 sidebar">
      </div>
    </div>
    <div class="back_to_top" id="back_to_top">
        <img src="./img/back_top_icon.png">
    </div>
    <!--  footer -->
    <script src="videodata.json" type="text/javascript"></script>
    <script>var videos = {!! $videos->toJson() !!};</script>
    <script src="./scripts/mainP.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
  </body>

</html>
