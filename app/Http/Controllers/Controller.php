<?php

namespace App\Http\Controllers;

use App\Preference;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getTheme()
    {
        return Preference::where('user_id',Auth::user()->id)->where('key','theme')->get(['value'])[0]->value;
    }

    public function resizePlaylistImage($image,$slug)
    {
        $imageName=false;
        if (isset($image)){
            //determination d'un nom unique pour l'image
            $curentdate=Carbon::now()->toDateString();
            $imageName=$slug.'-'.$curentdate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //creation du dossier post si il n'existe pas

            if (!Storage::disk('public')->exists('playlist/image')){
                Storage::disk('public')->makeDirectory('playlist/image');
            }

            //redimensionner et uploader l'image
            $categoryName=Image::make($image)->save($imageName);
            //$img->save(true);
            Storage::disk('public')->put('playlist/image/'.$imageName,$categoryName);
        }
        return $imageName;
    }

    public static function DeleteTemp($name){
        if (Storage::disk('pub')->exists($name)){
            Storage::disk('pub')->delete($name);
        }
    }
    public static function DeleteUpdate($name){
        if (Storage::disk('public')->exists('playlist/image/'.$name)){
            Storage::disk('public')->delete('playlist/image/'.$name);
        }
    }
}
