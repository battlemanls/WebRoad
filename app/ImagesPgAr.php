<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesPgAr extends Model
{

    protected $table = 'images_pg_ar';

    public function articles(){
        return $this->belongsTo('App\Articles', 'id_articles');
    }

    public function images(){
        return $this->belongsTo("App\Images", 'id_images');
    }

    public function pages(){
        return $this->belongsTo('App\WebPages', 'id_pages');
    }
}
