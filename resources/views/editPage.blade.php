@extends('layouts.navbar')

@section('style')
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="styles/edit.css">
@endsection

@section('content')
  
  <div class='container'>
  
    <h3><button class="editFinish" onclick="editFinish()">FINISH</button></h3>
      <span class="input-remind">上傳檔案將覆蓋當前字幕!</span>
      <input type="file" name="Upload_File[]" id="Upload_File" class="inputfile" accept=".srt">
    <div class="row">
      <div class="col col-sm-6 col-md-6 col-lg-6">
        <input placeholder="請在這裡輸入字幕" class = "input-form">
          <button class = "input-btn"><i class="fas fa-search"></i></button>
        </input>
        <div class="subtitle-list">
          <div class="subtitle-item last-item"></div>
        </div>
      </div>
      <div class="col col-sm-6 col-md-6 col-lg-6">
        <div id='player'></div>
        <p id='underSubtitles'></p>
      </div>
    </div>      
  </div>
@endsection

@section('script')
  <script src="./scripts/edit.js"></script>
@endsection

