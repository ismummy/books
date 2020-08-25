<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCharacter extends Model
{
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo('App\Models\Character');
    }
}
