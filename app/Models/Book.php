<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $guarded = [];

    public function authors()
    {
        return $this->belongsToMany('App\Models\Author', 'book_authors');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function characters()
    {
        return $this->belongsToMany('App\Models\Character', 'book_characters');
    }
}
