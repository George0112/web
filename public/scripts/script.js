
var url=window.location.href;
var engCaption=1;
var cnCaption=1;
var get_dict = false;
function captionLgnFunc(lng){
    if(lng=="eng"){
        if(engCaption==1)
            $('#eng_caption').css("color", "white");
        else
            $('#eng_caption').css("color", "rgb(255,0,0)");  
        
        engCaption=(engCaption==1)?0:1;
    }
    if(lng=="cn") {
        if(cnCaption==1)
            $('#cn_caption').css("color", "white");
        else
            $('#cn_caption').css("color", "rgb(255,0,0)");  
            
        cnCaption=(cnCaption==1)?0:1;
    }
    searchForSubtitle();
    
}

$(window).click((event) => {
    if(!$(event.target).closest('.popup').length){
        $('.popuptext').remove();
        get_dict = false;
        console.log(get_dict);
    }
});

function add_subtitude(){
    json = JSON.parse(subtitle);
    $.each(json[0].transcripts, function(index, d){
        var text = '';
        id=0;
        d.text.split(' ').map((i)=>{
            console.log(i);
            text += `<span class='popup' id='text`+id+`' onclick='ask_google("`+i+'",'+index+','+id+`)')>` + i+ " </span>";
            id++;
        });
		var sub = "<a class='list-group-item' onclick='playAt(" + index + ")' id='subtitle" + index + "'>" + text + "</a>"
        $(sub).appendTo('#subtitle');
    });
};

function ask_google(word, index, id){
    get_dict = true;
    console.log(get_dict, word);
    $.post("https://translation.googleapis.com/language/translate/v2?",
    {
        key: "AIzaSyAGjI6nBCUK1QAjqWxSuLFdWcv38pKENJ8",
        q: word,
        target:"zh-TW"
    },(data, status) => {
        appending = '#subtitle' + index + ' #text' + id;
        console.log(appending);
        $(appending).remove('#myPopup');
        $('.popuptext').remove();
        $(appending).append('<span class="popuptext" id="myPopup">'+data.data.translations[0].translatedText+'</span>');
        var popup = document.getElementById("myPopup");
        popup.classList.toggle("show");
    });
}

var getUrlParameter = function getUrlParameter(sParam) {
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

// load json file
var tag = document.createElement('script');

tag.src = "video" + getUrlParameter('index') + ".json";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '400',
        width: '100%',
        videoId: getUrlParameter('id'),
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    //event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = true;
var duration = 0;
var changeState = false;
var interval;
var repeatFlag = false;
var firstRepeat = true;
var currentSubtitle = 0;
function onPlayerStateChange(event) {
    console.log(event.data);
    if (event.data == YT.PlayerState.PLAYING && !done) {
		doneTimeOut = setTimeout(function(){
			player.pauseVideo();
		}, duration);
        done = true;
        console.log('stateChange and not done, duration = ' + duration);
    }else if (event.data == YT.PlayerState.PLAYING){
		changeState = true;
		renderSubtitle();
    }else if(event.data == YT.PlayerState.PAUSED && repeatFlag){
        console.log('repeat')
        repeat();
    }
}

function stopVideo() {
    player.stopVideo();
}

function playAt(index) {
    if(get_dict)return;
	if(typeof(doneTimeOut)!=='undefined')clearTimeout(doneTimeOut);
	if(typeof(changeTimeOut)!=='undefined')clearTimeout(changeTimeOut);
    if(typeof(renderTimeOut)!=='undefined')clearTimeout(renderTimeOut);
    console.log('playAt render')
    //////////////////////
    
    $.post("https://translation.googleapis.com/language/translate/v2?",
    {
        key: "AIzaSyAGjI6nBCUK1QAjqWxSuLFdWcv38pKENJ8",
        q: json[0].transcripts[index].text,
        target:"zh-TW"
    },
    function(data, status){
    if(engCaption && cnCaption){
        $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[index].text +"<br/>" + data.data.translations[0].translatedText+ "</p>");
    }
    else if(engCaption && !cnCaption){
        $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[index].text + "</p>");
    }
    else if(!engCaption && cnCaption){
        $("#underSubtitles").html("<p id='underSubtitle'> " + data.data.translations[0].translatedText + "</p>");
    }
    else {
        $("#underSubtitles").html("<p id='underSubtitle'> " +""+ "</p>");
    }
    
    });

    //////////////////////////////////////
    // if(engCaption==1 && cnCaption==1)
    //     $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[index].text +"<br/>" + cnCaptionCon+ "</p>");
	$(".list-group-item").each(function(){
        $(this).css("background-color", "white");
    });
	$('#subtitle'+index).css("background-color", "#bfbfbf");
	currentSubtitle = index;
	second = parseInt(json[0].transcripts[index].t)/1000;
	d = json[0].transcripts[index].d;
	duration = d-1;
    player.seekTo(second, 1);
	done = false;
    player.playVideo();
    console.log("playAt()");
    console.log(second + " " + d);
}

function searchForSubtitle(){
	var currentTime = parseInt(player.getCurrentTime()*1000);
	var minInterval = Number.MAX_VALUE;
	var i = 0;
	while (currentTime-json[0].transcripts[i].t >= 0){
		i++;
	}
	i--;
    if(i==-1)i=0;
    /////////////////////////////
    $.post("https://translation.googleapis.com/language/translate/v2?",
    {
        key: "AIzaSyAGjI6nBCUK1QAjqWxSuLFdWcv38pKENJ8",
        q: json[0].transcripts[i].text,
        target:"zh-TW"
    },
    function(data, status){
   
    if(engCaption && cnCaption){
        $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[i].text +"<br/>" + data.data.translations[0].translatedText+ "</p>");
    }
    else if(engCaption && !cnCaption){
        $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[i].text + "</p>");
    }
    else if(!engCaption && cnCaption){
        $("#underSubtitles").html("<p id='underSubtitle'> " + data.data.translations[0].translatedText + "</p>");
    }
    else {
        $("#underSubtitles").html("<p id='underSubtitle'> " +""+ "</p>");
    }
    });
    ////////////////////////////
	//$("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[i].text + "</p>");
	$(".list-group-item").each(function(){
        $(this).css("background-color", "white");
    });
    $('#subtitle'+i).css("background-color", "#bfbfbf");
    currentSubtitle = i;
    var top = $('#subtitle' + currentSubtitle).position().top-15;
    $('#subtitle').animate({
        scrollTop: '+=' + top
    }, 500)
}


function renderSubtitle(){
    //var i = searchForSubtitle();
	searchForSubtitle();
	if(typeof(doneTimeOut)!=='undefined')clearTimeout(doneTimeOut);
	if(typeof(changeTimeOut)!=='undefined')clearTimeout(changeTimeOut);
	if(typeof(renderTimeOut)!=='undefined')clearTimeout(renderTimeOut);
    //$("#underSubtitles").text(json[0].transcripts[i].text);
	if(player.getPlayerState()==1){
		renderTimeOut = setTimeout(function(){
			currentSubtitle++;
			changeState = false;
			changeSubtitle();
		}, json[0].transcripts[currentSubtitle+1].t-parseInt(player.getCurrentTime()*1000));
	}
}

function changeSubtitle(){
	if(player.getPlayerState()==1 && changeState == false){
        $.post("https://translation.googleapis.com/language/translate/v2?",
        {
            key: "AIzaSyAGjI6nBCUK1QAjqWxSuLFdWcv38pKENJ8",
            q: json[0].transcripts[currentSubtitle].text,
            target:"zh-TW"
        },
        function(data, status){
        if(engCaption && cnCaption){
            $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[currentSubtitle].text +"<br/>" + data.data.translations[0].translatedText+ "</p>");
        }
        else if(engCaption && !cnCaption){
            $("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[currentSubtitle].text + "</p>");
        }
        else if(!engCaption && cnCaption){
            $("#underSubtitles").html("<p id='underSubtitle'> " + data.data.translations[0].translatedText + "</p>");
        }
        else {
            $("#underSubtitles").html("<p id='underSubtitle'> " +""+ "</p>");
        }
        });
		//$("#underSubtitles").html("<p id='underSubtitle'> " + json[0].transcripts[currentSubtitle].text + "</p>");
		$(".list-group-item").each(function(){
			$(this).css("background-color", "white");
		});
        $('#subtitle'+currentSubtitle).css("background-color", "#bfbfbf");
        var top = $('#subtitle' + currentSubtitle).position().top-15;
        $('#subtitle').animate({
            scrollTop: '+=' + top
        }, 500)
        //document.getElementById("subtitle" + currentSubtitle).scrollIntoView(true);
		changeTimeOut = setTimeout(function(){
			currentSubtitle++;
			changeSubtitle();
		}, json[0].transcripts[currentSubtitle+1].t-parseInt(player.getCurrentTime()*1000));
	}
}

$(function() {
    $('#repeatToggle').change(function() {
        if($(this).prop('checked')) repeat();
        else stopRepeat();
    })
  })

function repeat(){
    if(typeof(doneTimeOut)!=='undefined')clearTimeout(doneTimeOut);
	if(typeof(changeTimeOut)!=='undefined')clearTimeout(changeTimeOut);
	if(typeof(renderTimeOut)!=='undefined')clearTimeout(renderTimeOut);
    done = true;
	playAt(currentSubtitle);
	repeatFlag = true;
}

function stopRepeat(){
    //player.pauseVideo();
    repeatFlag = false;
}