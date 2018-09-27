<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
