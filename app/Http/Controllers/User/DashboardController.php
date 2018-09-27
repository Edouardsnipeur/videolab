<?php

namespace App\Http\Controllers\User;

use App\Playlist;
use App\Preference;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


    public function index()
    {
        $theme=$this->getTheme();
        $video_count=Video::where('user_id',Auth::user()->id)->count();
        $approuved_count=Video::where('approuved',false)->where('user_id',Auth::user()->id)->count();
        $playlist_count=Playlist::where('user_id',Auth::user()->id)->count();
        return view('user.index',compact(['video_count','approuved_count','playlist_count','theme']));
    }
}
