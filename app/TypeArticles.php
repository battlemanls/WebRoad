<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeArticles extends Model
{
    protected $table = 'type_articles';


    public function articles()
    {
        return $this->belongsTo('App\Articles');
    }

}
