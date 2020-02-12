<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';


    public function files_pg_ars()
    {
        return $this->hasMany('App\FilesPgAr', 'id_files');
    }


   /* public function regions()
    {
        return $this->belongsTo('App\Regions', 'id_region');
    }*/

}
