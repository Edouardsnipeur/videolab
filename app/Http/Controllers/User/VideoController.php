<?php

namespace App\Http\Controllers\User;

use App\Category;
use App\Jobs\VideoTraitement;
use App\Tag;
use App\Video;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Pbmedia\LaravelFFMpeg\FFMpegFacade;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending()
    {
        $theme=$this->getTheme();
        $video = Video::with('category')
            ->where('id',Auth::user()->id)
            ->where('approuved',true)
            ->get();
        return view('user.video.approuve',compact(['video','theme']));
    }
    public function index()
    {
        $theme=$this->getTheme();
        $video = Video::with('category')->where('id',Auth::user()->id)->get();
        //dd($video);
        return view('user.video.index', compact(['video','theme']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme=$this->getTheme();
        $category=Category::all();
        return view('user.video.create',compact(['category','theme']));
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
            'name'=>'required',
            'category'=>'required',
            'video' => 'mimetypes:video/*',
        ]);
        //dd($request->video);
        $path = $request->file('video')->storeAs(
            'Serie', $request->video->getClientOriginalName(),'public'
        );
        $this->dispatch(new VideoTraitement($path,$request->name,$request->category,$request->tag,$request->desc,$request->video->getClientOriginalExtension()));
        //VideoTraitement::dispatch();
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $theme=$this->getTheme();
        $category=Category::all();
        return view('user.video.edit',compact(['video','category','theme']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $this->authorize('update_video',$video);
        $this->validate($request,[
            'name'=>'required',
            'category'=>'required',
        ]);
        $name=$request->name;
        $slug=str_slug($request->name);
        $description=$request->desc;
        $tag=$request->tag;
        $poster='default.png';
        $category_id=$request->category;
        $user=Auth::user()->id;


        //Traitement du tag pour avoir une relation manytomany en local
        $tag=explode(',',$request->tag);
        $size=count($tag);
        $tag_name=null;
        for($i=0;$i<$size;$i++){
            $tag_name[]=array_combine(['name'],[$tag[$i]]);
        }
        $id=null;
        foreach ($tag_name as $tn) {
            if (DB::table('tags')->where('name',$tn['name'])->doesntExist()){
                $id[]=DB::table('tags')->insertGetId($tn);
            }else{
                $id[]=DB::table('tags')->where('name',$tn['name'])->get(['id'])[0]->id;
            }
        }


        $video->name=$name;
        $video->slug=$slug;
        $video->poster=$poster;
        $video->category_id=$category_id;
        if ($description){$video->description=$description;}
        $video->user_id=$user;
        $video->save();
        $video->tags()->sync($id);
        Toastr::success('Video uploader avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->route('user.video.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        if (Storage::disk('public')->exists($video->unique_name)){
            Storage::disk('public')->delete($video->unique_name);
           // dd($video->unique_name);
        }
        $video->delete();
        Toastr::success('Video supprimer avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->back();
    }
}
