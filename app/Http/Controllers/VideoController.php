<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class VideoController extends Controller
{
    public function uploadVideo(Request $request)
    {
		$videoId = $request['videoId'];
		$accent = $request['accent'];
		$title = $request['title'];
		$time = $request['time'];
		$test = $request['test'];
		$level = $request['level'];
		//if(DB::table('video')->where('videoId', $videlId)) return 'success';
		$success = DB::table('video')->insert([
			['videoId' => $videoId, 'accent' => $accent, 'title' => $title, 'time' => $time, 'test' => $test, 'level' => $level]
		]);
		if($success) return 'success';
		else return 'fail';
    }
    public function getVideo(Request $request)
	{
		$videoId = $request['videoId'];
		$videos = DB::table('video')->paginate(15);
		if($videoId!=""){
			$videoPlays = DB::table('subtitle')->where('videoId',$videoId)->get();
			//$videoPlays= json_encode($videoPlays);
			//$sub=json_encode($videoPlays->subtitles);
			//echo "<script>console.log( 'Debug Objects:  '{$videoPlays->id}'' );</script>";
			//echo "<script>console.log( 'Debug Objects: " . $sub. "' );</script>";
			return view('videoPlay', ['videoPlays' => $videoPlays]);
			//return $videoPlays;
		}
		
		//$videos = json_encode($videos);
		return view('video', ['videos' => $videos]); 
	}
     public function getVideoData(Request $request)
	{
		$id = $request['videoId'];
		$videos = DB::table('video')->paginate(15);
		$videos = json_encode($videos);
		return $videos; 
	}
	public function getVideoSubtitle(Request $request)
	{
		$id = $request['id'];
		$videos = DB::table('subtitle')->where('videoId','=',$id)->get();
		return $videos; 
	}
	public function tryVariable(Request $request)
	{
		$subtitles = DB::table('subtitle')->select('subtitles')->where('id','19')->get();
		return view('tryVariable', ['subtitles' => $subtitles]);
	}
}
