<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Jobs\ResizeImage;
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
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
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
            ->where('approuved',false)
            ->get();
        return view('admin.video.approuve',compact(['video','theme']));
    }

    public function approuve(Video $video)
    {
        $video->approuved=true;
        $video->save();
        Toastr::success('Video valider avec success', 'success', ["positionClass" => "toast-bottom-left"]);
        return redirect()->back();
    }
    public function index()
    {
        $theme=$this->getTheme();
        $video = Video::with('category')->get();
        //dd($video);
        return view('admin.video.index', compact(['video','theme']));
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
        return view('admin.video.create',compact(['category','theme']));
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
        $uploaded=$request->video;
        $path = $uploaded->storeAs(
            'upload', str_slug(str_random(6).$uploaded->getClientOriginalName()).'.'.$uploaded->getClientOriginalExtension(),'public'
        );
        //dd($path);

//        $path = $uploaded->move(public_path('upload'),
//            str_slug(str_random(6).$uploaded->getClientOriginalName()).'.'.$uploaded->getClientOriginalExtension());
        $this->dispatch(new VideoTraitement($path,
            $request->all(['name','category','tag','desc']),
            $uploaded->getClientOriginalExtension(), Auth::user()));
        //VideoTraitement::dispatch();
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function affiche()
    {
        $categories=Category::all();
        return view('frontend.image',compact(['categories']));
    }

    public function upload(Request $request)
    {

        $uploaded=$request->image;
        $file=$uploaded->move(public_path('uploads'),$uploaded->getClientOriginalName());
        //dd($file->getRealPath());
        $formats=[100,200,300,400,500,600];

        $this->dispatch(new  ResizeImage($file,$formats));

        $categories=Category::all();
        return view('frontend.image',compact(['categories']));
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
        return view('admin.video.edit',compact(['video','category','theme']));
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
        return redirect()->route('admin.video.index');
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
