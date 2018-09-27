<?php

namespace App\Http\Controllers\Admin;

use App\Playlist;
use App\User;
use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $theme=$this->getTheme();
        $video_count=Video::all()->count();
        $user_count=User::all()->count();
        $approuved_count=Video::where('approuved',false)->count();
        $playlist_count=Playlist::all()->count();
        //dd($approuved_count);
        return view('admin.index',compact(['video_count','user_count','approuved_count','playlist_count','theme']));
    }
}
