<?php

namespace App\Http\Controllers\Admin;

use App\Playlist;
use App\Video;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theme=$this->getTheme();
        $playlist = Playlist::with('videos')->get();
        return view('admin.playlist.index', compact(['playlist','theme']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme=$this->getTheme();
        return view('admin.playlist.create',compact(['theme']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=> 'required|unique:playlists',
            'image'=>'mimes:jpg,png,jpeg,bmp',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $playlist=new Playlist();
        //permet de redimensionner l'image. Cette fonction se trouve dans le controlleur principal
        if ($this->resizePlaylistImage($image,$slug)){
            $playlist->image=$this->resizePlaylistImage($image,$slug);
            self::DeleteTemp($playlist->image);
        }
        $playlist->name=$request->name;
        $playlist->slug=$slug;
        $playlist->user_id=Auth::user()->id;
        $playlist->save();
        Toastr::success('Playlist sauvergarder avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->route('admin.playlist.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        $theme=$this->getTheme();
        $videos=DB::table('videos')->get(['id','name']);
        $playlist_videos=$playlist->videos;
        ///dd($playlist_videos);
        return view('admin.playlist.show',compact(['playlist','videos','playlist_videos','theme']));
    }

    public function insert_video(Request $request)
    {

        $this->validate($request,[
            'playlist_id'=>'required'
        ]);
        $playlist=Playlist::find($request->playlist_id);
        $playlist->videos()->sync($request->video);
        Toastr::success('Playlist Modifier avec success', 'success', ["positionClass" => "toast-bottom-right"]);
        return redirect()->route('admin.playlist.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $theme=$this->getTheme();
        return view('admin.playlist.create',compact(['playlist','theme']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $this->validate($request,[
            'name'=> 'required',
            'image'=>'mimes:jpg,png,jpeg,bmp',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        //permet de redimensionner l'image. Cette fonction se trouve dans le controlleur principal
        if ($name=$this->resizePlaylistImage($image,$slug)){
            self::DeleteUpdate($playlist->image);
            $playlist->image=$name;
            self::DeleteTemp($name);

        }
        $playlist->name=$request->name;
        $playlist->slug=$slug;
        $playlist->save();
        Toastr::success('Playlist Modifier avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->route('admin.playlist.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        Toastr::success('Playlist supprimer avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->route('admin.playlist.index');

    }
}
