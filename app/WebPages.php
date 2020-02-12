<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebPages extends Model
{
    protected $table = 'web_pages';


    public function files_pg_ars()
    {
        return $this->hasMany('App\FilesPgAr', 'id_pages');
    }

    public function images_pg_ars()
    {
        return $this->hasMany('App\ImagesPgAr', 'id_pages');
    }

}
