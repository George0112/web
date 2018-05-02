@extends('layouts.navbar')

@section('style')
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="styles/video.css">
  <script src='fb.js'></script>
@endsection

@section('content')
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
                <span id='repeatText'>Repeat</span><input type="checkbox" data-toggle="toggle" id="repeatToggle" data-size="small">
              </label>
            </div>
          </div>
        </div>
        <div class='col col-md-6 col-lg-6 col-sm-12'>
          <ol class='list-group control-time' id='subtitle'></ol>
        </div>
      </div>
      <div class='row'>
        <div class='col col-md-12 col-lg-12 col-sm-12' id='my-fb-comments'>
          <div class="fb-comments"
            data-href="http://140.114.79.72"
            data-numposts="10"
            data-width="100%"
            data-colorscheme="light">
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
    <script src="./scripts/script.js"></script>
@endsection

