<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
class Video extends Model

{

    //use Searchable;
    public function getRouteKeyName()
    {
        return 'slug'; // TODO: Change the autogenerated stub
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
