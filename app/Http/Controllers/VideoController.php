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
		 DB::table('video')->insert([
			['videoId' => $videoId, 'accent' => $accent, 'title' => $title, 'time' => $time, 'test' => $test, 'level' => $level]
		]);
		return 'success';
    }
}
