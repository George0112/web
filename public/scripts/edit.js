function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
function loadYoutube(){
  

}
var tag = document.createElement('script');  
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;
function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '390',
      width: '640',
      videoId: getUrlParameter('id'),
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
}
function onPlayerReady(event) {
  //console.log(player.getVideoData().title);
}
function onPlayerStateChange(event) {
  if (event.data == YT.PlayerState.PLAYING) {
    renderSubtitle();
  }
}
function stopVideo() {
  player.stopVideo();
}

function renderSubtitle(){
  if(player.getPlayerState()==1){
    var currentTime = parseFloat(player.getCurrentTime());

    
  
    var i = 0;
    var havesubtitle = false;
    var subtitleId;
    $(".subtitle-item").each(function(){
        var start_time = parseFloat($(this).find(".subtitle-time").find(".start-time").val());
        var duration = parseFloat($(this).find(".subtitle-time").find(".end-time").val())-parseFloat($(this).find(".subtitle-time").find(".start-time").val());
        if(currentTime>= start_time && currentTime< start_time+duration){
          havesubtitle = true;
          subtitleId = $(this).attr('id');
          return false;
        }
      });
  
    if(i==-1) i = 0;
  
    //clear all highlight
    $(".subtitle-item").each(function(){
      $(this).css("border-left", "");
    });
  
    if(havesubtitle == true){
    //  console.log($(`#${subtitleId}`).find(".subtitle-text").val());
      $('#underSubtitles').text($(`#${subtitleId}`).find(".subtitle-text").val());
      //highlight current subtitle
      
      $(`#${subtitleId}`).css("border-left", "5px solid red");  
      renderTimeOut = setTimeout(function(){      
        $('#underSubtitles').text("");
        renderSubtitle();
      },(parseFloat($(this).find(".subtitle-time").find(".end-time").val())-currentTime)*1000);
    }else{
      $('#underSubtitles').text("");
      renderTimeOut = setTimeout(function(){
        console.log("else");
        renderSubtitle();
      },1000);
    }
    
  }
  
  


}
//change SRT time to min-sec
function changeSec(s){
  var range = s.split(':');
  var second = range[2].split(',');
  var output = second[0]+'.'+second[1];
  return output;
}
var subtitleId = 0;
// input subtitles
function inputform(){
  var submit = document.querySelector(".input-btn");
  submit.addEventListener("click", function(){
      var noInt = false;
      var start = player.getCurrentTime();
      $(".subtitle-item").each(function(){
        var s = $(this).find('.subtitle-time').find(".start-time").val();
        var e = $(this).find('.subtitle-time').find(".end-time").val();
        if((parseFloat(s)<=start) && (parseFloat(e)>=start)){
            alert("No Interval To Add Subtitle");
            noInt = true;
            return false;
        }
      });
    if(noInt === false){
      var input = $(".input-form").val();
      $(".subtitle-item").each(function(){
        //no subtitle
        if($(this).hasClass("last-item")){
          console.log("last");
          $(this).before(`<div class='subtitle-item' id='sub${subtitleId}'></div>`);
        
          var start = player.getCurrentTime().toFixed(2);
          var end = (player.getCurrentTime()+2).toFixed(2);
          //add subtitle-time
          $(this).prev().append(`<span class='subtitle-time'></span>`);
          $(this).prev().find('.subtitle-time').append(`<input class='start-time' value='${start}'></input>`);
          $(this).prev().find('.subtitle-time').append(`<input class='end-time' value='${end}'></input>`);
          //add subtitle-text
          $(this).prev().append(`<input class='subtitle-text' value='${input}'></input>`);
          //add subtitle-add subtitle-remove
          $(this).prev().append(`<span class='subtitle-icon'>
          <button class = "add" ><i class="fas fa-plus-circle"></i></button>
          <button class = "delete"><i class="fas fa-times-circle"></i></button>
          </span>`);
          
          var thebutton = newButton(subtitleId);
          var addButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".add").get(0);
          var removeButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".delete").get(0);
          addButton.addEventListener('click', thebutton.addclick);
          removeButton.addEventListener('click', thebutton.removeclick);
          
        
          subtitleId++;
          return false;
        }
        //compare start time 
        else if(parseInt($(this).find(".subtitle-time").find(".start-time").val()) > parseInt(player.getCurrentTime().toFixed(2)))
        {
          $(this).before(`<div class='subtitle-item' id='sub${subtitleId}'></div>`);
          
          var start = player.getCurrentTime().toFixed(2);
          var end = (player.getCurrentTime()+2).toFixed(2);
          //add subtitle-time
          $(this).prev().append(`<span class='subtitle-time'></span>`);
          $(this).prev().find('.subtitle-time').append(`<input class='start-time' value='${start}'></input>`);
          $(this).prev().find('.subtitle-time').append(`<input class='end-time' value='${end}'></input>`);
          //add subtitle-text
          $(this).prev().append(`<input class='subtitle-text' value='${input}'></input>`);
          //add subtitle-add subtitle-remove
          
          $(this).prev().append(`<span class='subtitle-icon'>
          <button class = "add"><i class="fas fa-plus-circle"></i></button>
          <button class = "delete"><i class="fas fa-times-circle"></i></button>
          </span>`);
          var thebutton = newButton(subtitleId);
          var addButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".add").get(0);
          var removeButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".delete").get(0);
          addButton.addEventListener('click', thebutton.addclick);
          removeButton.addEventListener('click', thebutton.removeclick);
          
          
          subtitleId++;
          return false;
        }
      });
    }

  // clear input-form
    $(".input-form").val('');

    
  });
}
//closure button
function newButton(id){
  return{
    addclick: function addclick(){
      console.log("closure add");
      var prev_end_time = parseFloat($(`#sub${id}`).find('.subtitle-time').find('.end-time').val());
      var next_start_time = parseFloat($(`#sub${id}`).next().find(".subtitle-time").find(".start-time").val());
      if(isNaN(next_start_time)){
        next_start_time = prev_end_time+2;
      } 
      //if two subtitles don't have space to add new subtitle
      if(prev_end_time == next_start_time){
        alert("No Interval to Insert Subtitle");
      }
      else{
        $(`#sub${id}`).after(`<div class='subtitle-item' id='sub${subtitleId}'></div>`);
        var start = $(`#sub${id}`).find('.subtitle-time').find('.end-time').val();
        if( prev_end_time+2 <= next_start_time){
          next_start_time = prev_end_time+2;
        }
        console.log(prev_end_time);
        $(`#sub${subtitleId}`).append(`<span class='subtitle-time'></span>`);
        $(`#sub${subtitleId}`).find('.subtitle-time').append(`<input class='start-time' value='${prev_end_time.toFixed(2)}'></input>`);
        $(`#sub${subtitleId}`).find('.subtitle-time').append(`<input class='end-time' value='${next_start_time.toFixed(2)}'></input>`);
        $(`#sub${subtitleId}`).append(`<input class='subtitle-text' value=''></input>`);
        $(`#sub${subtitleId}`).append(`<span class='subtitle-icon'>
        <button class = "add"><i class="fas fa-plus-circle"></i></button>
        <button class = "delete"><i class="fas fa-times-circle"></i></button>
        </span>`);
        var thebutton = newButton(subtitleId);
        var addButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".add").get(0);
        var removeButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".delete").get(0);
        addButton.addEventListener('click', thebutton.addclick);
        removeButton.addEventListener('click', thebutton.removeclick);
        subtitleId++;
        
      }
    },
    removeclick: function removeclick(){
      $(`#sub${id}`).remove();
    }
  }
}


//click subtitle event ex.player seekto ,change highlight
function clickSubtitle(){
  //clear all highlight
  $(document).on('click', '.subtitle-item', function(event){
    $(".subtitle-item").each(function(){
      $(this).css("border-left", "");
    });
  //highlight click subtitle
  $(this).css("border-left", "5px solid red");
  //seet to start time
  var start = parseInt($(this).find(".subtitle-time").find(".start-time").val());
  player.seekTo(start);
  });
}


function readFile(){
  var filedata=[];
  file = this.files[0];
  var fReader = new FileReader();           
  fReader.onload = function (event) {
    
      var text = event.target.result.toString();
      var lines = text.split('\n');
      var count = 1;
      var index = -1,start = -1,end = -1,subtitle = '';
      lines.forEach(function(line) {
        if(index === -1){
          index = line;
        }
        else if(start === -1) {
            var range = line.split(' --> ');
            start = range[0];
            end = range[1];
        }
        else if(line.length > 1){
            subtitle = subtitle+line;
        }
        else {
            filedata.push({"index":index,"start":start,"end":end,"subtitle":subtitle});
            index = -1,start = -1,end = -1,subtitle = '';
        }
    });
    loadSubtitle(filedata);
  };
  fReader.readAsText(file);

}
//load subtitle from srt
function loadSubtitle(filedata){
  $(".subtitle-item").each(function(){
    if($(this).hasClass( "last-item" )){
      
    }
    else{
      $(this).remove();
    }
  }
  );
  for(var i = 0;i < filedata.length;i++){

    var start = parseFloat(changeSec(filedata[i].start));
    var end = parseFloat(changeSec(filedata[i].end));

    $(".subtitle-list").append(`<div class='subtitle-item' id='sub${subtitleId}'></div>`);
    $(`#sub${subtitleId}`).append(`<span class='subtitle-time'></span>`);
    $(`#sub${subtitleId}`).find('.subtitle-time').append(`<input class='start-time' value='${start.toFixed(2)}'></input>`);
    $(`#sub${subtitleId}`).find('.subtitle-time').append(`<input class='end-time' value='${end.toFixed(2)}'></input>`);
    $(`#sub${subtitleId}`).append(`<input class='subtitle-text' value='${filedata[i].subtitle}'></input>`);
    $(`#sub${subtitleId}`).append(`<span class='subtitle-icon'>
    <button class = "add"><i class="fas fa-plus-circle"></i></button>
    <button class = "delete"><i class="fas fa-times-circle"></i></button>
    </span>`);
    var thebutton = newButton(subtitleId);
    var addButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".add").get(0);
    var removeButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".delete").get(0);
    addButton.addEventListener('click', thebutton.addclick);
    removeButton.addEventListener('click', thebutton.removeclick);
    subtitleId++;
  }
  $(".last-item").remove();
  $(".subtitle-list").append(`<div class='subtitle-item last-item'></div>`);
}
//click edit finish event
function editFinish(){
  var postData={"text":[]};
  $(".subtitle-item").each(function(){
    var start_time = parseFloat($(this).find(".subtitle-time").find(".start-time").val());
    var duration = parseFloat($(this).find(".subtitle-time").find(".end-time").val())-parseFloat($(this).find(".subtitle-time").find(".start-time").val());
    var subtitle = $(this).find(".subtitle-text").val();
    if(!isNaN(start_time)){
      postData.text.push({"@attributes":{"dur":duration.toFixed(2),"start":start_time.toFixed(2),"subtitle":subtitle}});
    }
    
  });
  console.log(postData);
  postData = JSON.stringify(postData);
  //post to server
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
  $.ajax({
    type: 'POST',
    url: `http://140.114.79.72/editFinish`,
    data: {'data':postData,'id':getUrlParameter('id'),'title':player.getVideoData().title},
    dataType: "json",
    success: function(){
      console.log("post success");
    }
  });
  //go to index page
  window.location.href=`./videoPage?id=${getUrlParameter('id')}`;
}
function getSubtitle(){
  $.ajax({
    async: false,
    url: `http://140.114.79.72/video/subtitle?id=${getUrlParameter('id')}`,
    type: "GET",
    success: function(data){
        console.log(`http://140.114.79.72/video/subtitle?id=${getUrlParameter('id')}`)
       //console.log(data[0].subtitles);
       if(data[0].subtitles=="null"){
         console.log("null");
       }
       else{
          json = JSON.parse(data[0].subtitles);    
          loadDBSubtitle(json.text);
       }
     
    }
  });
}
//load subtitle from DB
function loadDBSubtitle(data){
  console.log(data);
  for(var i = 0;i < data.length;i++){

    var start = parseFloat(data[i]["@attributes"].start);
    var end = parseFloat(data[i]["@attributes"].start)+parseFloat(data[i]["@attributes"].dur);

    $(".subtitle-list").append(`<div class='subtitle-item' id='sub${subtitleId}'></div>`);
    $(`#sub${subtitleId}`).append(`<span class='subtitle-time'></span>`);
    $(`#sub${subtitleId}`).find('.subtitle-time').append(`<input class='start-time' value='${start.toFixed(2)}'></input>`);
    $(`#sub${subtitleId}`).find('.subtitle-time').append(`<input class='end-time' value='${end.toFixed(2)}'></input>`);
    $(`#sub${subtitleId}`).append(`<input class='subtitle-text' value='${data[i]["@attributes"].subtitle}'></input>`);
    $(`#sub${subtitleId}`).append(`<span class='subtitle-icon'>
    <button class = "add"><i class="fas fa-plus-circle"></i></button>
    <button class = "delete"><i class="fas fa-times-circle"></i></button>
    </span>`);
    var thebutton = newButton(subtitleId);
    var addButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".add").get(0);
    var removeButton = $(`#sub${subtitleId}`).find(".subtitle-icon").find(".delete").get(0);
    addButton.addEventListener('click', thebutton.addclick);
    removeButton.addEventListener('click', thebutton.removeclick);
    subtitleId++;
  }
  $(".last-item").remove();
  $(".subtitle-list").append(`<div class='subtitle-item last-item'></div>`);
}
window.onload = function(){
  getSubtitle();
  inputform();
  clickSubtitle();
  document.getElementById('Upload_File').onchange = readFile;
}