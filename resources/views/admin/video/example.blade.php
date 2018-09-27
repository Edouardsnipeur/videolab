<form>

    <div class="form-group form-float">
        <div class="form-line">
            <input type="text" id="name" class="form-control" name="name" value="{{isset($video->name)?$video->name:''}}" requi/>
            <label class="form-label">Nom du video</label>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group form-float">
                <p>
                    <b>Categories</b>
                </p>
                <select class="form-control show-tick" name="category">
                    @foreach($category as $v)
                        <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group demo-tagsinput-area">
                <div class="form-line">
                    <input type="text" name="tag" class="form-control" data-role="tagsinput" placeholder="">
                    <div class="help-info">Veuillez taper sur enter apres chaque TAG</div>
                </div>
            </div>

        </div>
    </div>


    <div class="form-group form-float">
        <div class="form-line">
            <textarea rows="4" id="desc" name="desc" class="form-control no-resize" placeholder="Veuillez saisir la description..."></textarea>
        </div>
    </div>
    <a href="{{route('admin.video.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">Retour</a>
    <button type="submit" id="submit" class="btn btn-primary m-t-15 waves-effect">Upload et Publier</button>
</form>


//forget to add minuite and description column to videotable
//$d=new \DateTime();
//dd($d->modify('180 seconds')->format('h:i:s'));






$this->validate($request,[
'name'=>'required',
'category'=>'required',
'video' => 'mimetypes:video/*',
]);

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


$video = $request->file('video');
$name=$request->name;
$slug=str_slug($request->name);
$description=$request->desc;

$poster='default.png';
$category_id=$request->category;
$user=Auth::user()->id;



//determination d'un nom unique pour l'image
$curentdate=Carbon::now()->toDateString();
$videoName=$slug.'-'.$curentdate.'-'.uniqid().'.'.$video->getClientOriginalExtension();
//creation du dossier Category si il n'existe pas

$category=Category::find($category_id)->name;
if (!Storage::disk('public')->exists($category)){
Storage::disk('public')->makeDirectory($category);
}

$path = $request->file('video')->storeAs(
$category, $videoName,'public'
);
$media = FFMpegFacade::fromDisk('public')->open($path);
if ($media->getDurationInSeconds()<3600){
$duration = gmdate('i:s',$media->getDurationInSeconds());

}else{
$duration = gmdate('h:i:s',$media->getDurationInSeconds());
}



$video= new Video();
$video->name=$name;
$video->unique_name=$path;
$video->slug=$slug;
$video->poster=$poster;
$video->category_id=$category_id;
$video->description=$description;
$video->duration=$duration;
$video->user_id=$user;
$video->save();
$video->tags()->sync($id);