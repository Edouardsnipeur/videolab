<?php

namespace App\Jobs;

use App\Category;
use App\User;
use App\Video;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Pbmedia\LaravelFFMpeg\FFMpeg;
use Pbmedia\LaravelFFMpeg\FFMpegFacade;


class VideoTraitement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $path;
    private $extension;
    private $request;
    private $user;
    public function  __construct(string $path, Array $request,string $extension,User $user)
    {
        $this->path=$path;
        $this->request=$request;
        $this->extension = $extension;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id =null;
        if (!is_null($this->request['tag'])){
            //dd($this->request['tag']);
            //Traitement du tag pour avoir une relation manytomany en local
            $tag=explode(',',$this->request['tag']);
            $size=count($tag);
            //dd($size);
            $tag_name=null;
            for($i=0;$i<$size;$i++){
                $tag_name[]=array_combine(['name'],[$tag[$i]]);
            }

            foreach ($tag_name as $tn) {
                if (DB::table('tags')->where('name',$tn['name'])->doesntExist()){
                    $id[]=DB::table('tags')->insertGetId($tn);
                }else{
                    $id[]=DB::table('tags')->where('name',$tn['name'])->get(['id'])[0]->id;
                }
            }
        }



        //$video = Storage::disk('public')->get($this->path);
        $name=$this->request['name'];
        $slug=str_slug($name);
        $description=$this->request['desc'];
        $poster='poster/'.$slug.str_random(8).'.png';
        $category_id=$this->request['category'];





//determination d'un nom unique pour l'image
        $curentdate=Carbon::now()->toDateString();
        $videoName=$slug.'-'.$curentdate.'-'.uniqid().'.'.$this->extension;
//creation du dossier Category si il n'existe pas

        $category=Category::find($category_id)->name;
        if (!Storage::disk('public')->exists($category)){
            Storage::disk('public')->makeDirectory($category);
        }

        Storage::putFileAs('public/'.$category, new File(storage_path('app/public/'.$this->path)), $videoName);

        $media = FFMpegFacade::fromDisk('public')->open($category.'/'.$videoName);
        if ($media->getDurationInSeconds()<3600){
            $duration = gmdate('i:s',$media->getDurationInSeconds());

        }else{
            $duration = gmdate('h:i:s',$media->getDurationInSeconds());
        }


            $media->getFrameFromSeconds($media->getDurationInSeconds()/2)
            ->export()
            ->toDisk('public')
            ->save($poster);

        $manager= new ImageManager();
        $manager->make(storage_path('app/public/'.$poster))
            ->fit(1625,1082)
            ->save(storage_path('app/public/'.$poster));


        Storage::delete($this->path);
        $video= new Video();
        $video->name=$name;
        $video->unique_name=$category.'/'.$videoName;
        $video->slug=$slug;
        $video->poster=$poster;
        $video->category_id=$category_id;
        $video->description=$description;
        $video->duration=$duration;
        $video->user_id=$this->user->id;
        if ($this->user->role==1){
            $video->approuved=true;
        }

        $video->save();
        if (!is_null($id)){
            $video->tags()->sync($id);
        }

    }
}
