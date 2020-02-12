<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilesPgAr extends Model
{
    protected $table = 'files_pg_ar';
    protected $fillable = ['id_pages', 'id_files', 'id_articles'];

    public function articles(){
        return $this->belongsTo('App\Articles', 'id_articles');
    }

    public function files(){
        return $this->belongsTo("App\Files", 'id_files');
    }

    public function pages(){
        return $this->belongsTo('App\WebPages', 'id_pages');
    }
}
