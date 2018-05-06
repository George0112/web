<?php

namespace App\Http\Controllers;
use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\Process\Process;
use App\Http\Controllers\YoutubeCrawler;

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
			return view('videoPlay', ['videoPlays' => $videoPlays]);
		}
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
	
	public function insertVideo(Request $request)
	{
		$user = Auth::user();
		$v = $request['v'];
		//return dirname($v);
		$playlistId = Null;
		if(dirname($v) == "https://youtu.be") $videoId = mb_substr(basename($v),0,11); 
		else if(dirname($v) == "https://www.youtube.com"){
			$query_str = parse_url($v, PHP_URL_QUERY);
			parse_str($query_str, $query_params);
			$playlistId = array_key_exists("list", $query_params) ? $query_params['list'] : Null;
			$videoId = array_key_exists("v", $query_params) ? $query_params['v'] : Null;
		}
		else $videoId = Null;
	
		if($playlistId){
			$url = 'https://www.googleapis.com/youtube/v3/playlistItems?maxResults=50&part=snippet&key='.$_ENV['GOOGLE_API_KEY'].'&playlistId='.$playlistId;
			$list = json_decode(file_get_contents($url));
			foreach($list->items as $item){
				$videoId = $item->snippet->resourceId->videoId;
				$crawler = new YoutubeCrawler($videoId);
				$information = $crawler->getInformation();
				$captions = $crawler->getCaptions();
				$title = $information['items'][0]['snippet']['title'];
				$duplicate = DB::table('userVideoList')->where('userId', $user['id'])->where('videoId', $videoId)->count();
				if(!$duplicate){
					$success = DB::table('userVideoList')->insert([
						['userId' => $user['id'], 'videoId' => $videoId, "created_at" =>  \Carbon\Carbon::now('Asia/Taipei')]
					]);
				}
				$duplicate = DB::table('video')->where('videoId', $videoId)->count();
				if(!$duplicate){
					$success = DB::table('video')->insert([
						['videoId' => $videoId, "created_at" =>  \Carbon\Carbon::now('Asia/Taipei'), "title" => $title, 
							"accent" => 'Null', 'time' => 'Null', 'test' => 0, 'level' => 'Null']
					]);
				}
				$duplicate = DB::table('subtitle')->where('videoId', $videoId)->count();
				if(!$duplicate){
					$success = DB::table('subtitle')->insert([
						['videoId' => $videoId, 'subtitles' => $captions]
					]);
				}
			}
			return redirect('/videoPage?id='.$videoId);
		}
		else if($videoId){
			$crawler = new YoutubeCrawler($videoId);
			$information = $crawler->getInformation();
			$captions = $crawler->getCaptions();
			$title = $information['items'][0]['snippet']['title'];
			$duplicate = DB::table('userVideoList')->where('userId', $user['id'])->where('videoId', $videoId)->count();
			if(!$duplicate){
				$success = DB::table('userVideoList')->insert([
					['userId' => $user['id'], 'videoId' => $videoId, "created_at" =>  \Carbon\Carbon::now('Asia/Taipei')]
				]);
			}
			$duplicate = DB::table('video')->where('videoId', $videoId)->count();
			if(!$duplicate){
				$success = DB::table('video')->insert([
					['videoId' => $videoId, "created_at" =>  \Carbon\Carbon::now('Asia/Taipei'), "title" => $title, 
						"accent" => 'Null', 'time' => 'Null', 'test' => 0, 'level' => 'Null']
				]);
			}
			$duplicate = DB::table('subtitle')->where('videoId', $videoId)->count();
			if(!$duplicate){
				$success = DB::table('subtitle')->insert([
					['videoId' => $videoId, 'subtitles' => $captions]
				]);
			}
			return redirect('/videoPage?id='.$videoId);
		}else return view('insertVideo', ['wrong_url' => true]);
	}

	public function getUserVideoList(Request $request)
	{
		$user = Auth::user();
		$list = DB::table('userVideoList')->join('video', 'video.videoId', '=', 'userVideoList.videoId')->select('video.videoId', 'video.title')->where('userId', $user['id'])->get();
		$list = json_encode($list);
		return $list;
	}

	public function getInsertVideo(Request $request)
	{
		return view('insertVideo', ['wrong_url' => false]);
	}
  public function getIndex(Request $request)
  {
    return view('index');
  }
    public function getVideoPage(Request $request)
  {
	$user = Auth::user();
	$list = DB::table('userVideoList')->join('video', 'video.videoId', '=', 'userVideoList.videoId')->select('video.videoId', 'video.title')->where('userId', $user['id'])->get();
	//$list = json_encode($list);
    return view('videoPage', ['list' => $list]);
  }
}
