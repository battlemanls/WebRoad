<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roads extends Model
{

    public function type_roads()
    {
        return $this->belongsTo('App\TypeRoads', 'id_type');
    }

    public function regions()
    {
        return $this->belongsTo('App\Regions', 'id_region');
    }

}
