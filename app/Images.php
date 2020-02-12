<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{

    protected $table = 'images';

    public function files_pg_ars()
    {
        return $this->hasMany('App\ImagesPgAr', 'id_images');
    }
}
