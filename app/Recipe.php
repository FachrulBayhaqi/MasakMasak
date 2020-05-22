<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = "recipes";

    public function user() {
        return $this->belongsTo('App\User', 'author_id');
    }
    
}
