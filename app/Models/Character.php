<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $guarded = [];

    public function books(){
        return $this->belongsToMany('App\Models\Book', 'book_characters');
    }
}
