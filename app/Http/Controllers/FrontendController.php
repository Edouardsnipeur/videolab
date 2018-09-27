<?php

namespace App\Http\Controllers;

use App\Category;
use App\Playlist;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {//Auth::logout();
        //dd(gmdate('H:i:s', 100));
        $categories=DB::table('categories')->get(['id','name','image']);
        $recents=Video::with('user')->where('approuved',true)->orderByDesc('created_at')->limit(3)->get();
        $animes=Video::with('user')->where('approuved',true)->orderByDesc('created_at')->where('category_id',2)->limit(16)->get();
        $randoms = Video::with('user')->where('approuved',true)->inRandomOrder()->limit(8)->get();
        $series=Video::with('user')->where('approuved',true)->orderByDesc('created_at')->where('category_id',1)->limit(8)->get();
        return view('frontend.welcome',compact(['recents','animes','randoms','series','categories']));
    }

    public function category(Category $category)
    {
        $categories=DB::table('categories')->get(['id','name','image']);
        $videos=Video::with('user')->where('approuved',true)->orderByDesc('created_at')->where('category_id',$category->id)->paginate(6);
        return view('frontend.category',compact(['videos','categories','category']));
    }

    public function single(Video $video)
    {
        //dd($video);
        $categories=DB::table('categories')->get(['id','name','image']);
        //$videos=DB::table('videos')->where('category_id',$video->category_id)->get();
        $videos=Video::where('category_id',$video->category_id)->where('approuved',true)->inRandomOrder()->paginate(8);
        return view('frontend.single',compact(['categories','video','videos']));
    }


    public function playlist()
    {
        $categories=DB::table('categories')->get(['id','name','image']);
        $playlists=Playlist::with('videos')->orderByDesc('created_at')->paginate(16);
        return view('frontend.playlist',compact(['categories','playlists']));
    }
    public function search(Request $request)
    {
        $video=Video::search($request->search)->get();
        dd($video);
    }


    /**
     *
     */
    public function playlistSingle(Playlist $playlist)
    {
        $categories=DB::table('categories')->get(['id','name','image']);
        $video=false;
        $playlists=Playlist::with('videos')->where('id',$playlist->id)->get();
        $videos=Video::inRandomOrder()->where('approuved',true)->paginate(8);
        //dd($playlists[0]->videos);
        return view('frontend.singleplaylist',compact(['categories','videos','playlists','video']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
