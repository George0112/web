@extends('layouts.navbar')

@section('content')
<div class="container" id="list">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Insert My Video</div>
                <div class="card-body" onClick="insertVideo()">
                    <form method="POST" action="/insertVideo"`>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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

function getList()
{
	$.get("https://www.googleapis.com/youtube/v3/playlistItems",
	{
		key: "AIzaSyAGjI6nBCUK1QAjqWxSuLFdWcv38pKENJ8",
		part: "snippet",
		maxResults: 50,
		playlistId: getUrlParameter('list')
	}, (data, status) => {
		console.log(data.items);
		data.items.map((d) => {
			$('#list').append('<div class="row justify-content-center"> <div class="col col-md-8"><div class="card"> <img src="' 
				+ d.snippet.thumbnails.medium.url 
				+ '"/></div></div></div>');
		});
	});

}
function insertVideo()
{
console.log('click');	
}
</script>
@endsection
@section('style')
<style>
h4{
	float: left;
}
img {
    border: 1px solid #ddd; /* Gray border */
    border-radius: 4px;  /* Rounded border */
    padding: 5px; /* Some padding */
    width: 150px; /* Set a small width */
	display: inline;
	float: left;
}

/* Add a hover effect (blue shadow) */
img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
@endsection
