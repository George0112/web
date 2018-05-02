@extends('layouts.navbar')

@section('style')
  <link rel="stylesheet" type="text/css" href="styles/main.css">
@endsection
  
@section('content')
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
        <div class = "videospan"></div>
        <ul class="pagination pagination-sm"></ul>

      </div>

      <div class = "col col-md-3 sidebar">
        <!--img src="https://cdn.voicetube.com/assets/thumbnails/aEzMwNBjkAU.jpg" class = "side"></img-->
      </div>

    </div>



    <div class="back_to_top" id="back_to_top">
        <img src="./img/back_top_icon.png">
    </div>
@endsection

@section('script')
  <script src="videodata.json" type="text/javascript"></script>
  <script src="./scripts/main.js"></script>
  <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
@endsection