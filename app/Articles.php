<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    public function files_pg_ars()
    {
        return $this->hasMany('App\FilesPgAr', 'id_articles');
    }

    public function images_pg_ars()
    {
        return $this->hasMany('App\ImagesPgAr', 'id_articles');
    }

    public function type_articlesss()
    {
        return $this->belongsTo('App\TypeArticles', 'id_type');
    }

    public function block_newsss()
    {
        return $this->hasOne('App\BlockNews', 'id_articles')->orderBy('index_position', 'desc');
    }



}
