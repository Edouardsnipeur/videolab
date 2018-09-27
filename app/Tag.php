<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use Searchable;
    protected $fillable=['name','video_id'];
    //public $timestamps=false;
    public function video()
    {
        return $this->belongsToMany(Video::class);
    }
}
