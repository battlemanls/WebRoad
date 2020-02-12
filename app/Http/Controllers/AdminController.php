<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view("admin_panel/index");
    }

    public function delete_trash(){
       try {
           $images = App\Images::doesntHave('files_pg_ars')->get();
           if(isset($images)&&count($images)!=0) {
               foreach ($images as $i) {
                   //  $file_path = public_path().'/storage/uploads/images/'.$i->path;
                   $path = public_path() . '/storage/uploads/images/' . date_create($i->created_at)->Format('Y_m') . '/' . 'gallery/' . 'big/' . $i->path;
                   $path_2 = public_path() . '/storage/uploads/images/' . date_create($i->created_at)->Format('Y_m') . '/' . 'gallery/' . 'small/' . $i->path;
                   File::delete($path);
                   // $file_path_2 = public_path().'/storage/uploads/images/small/'.$i->path;
                   File::delete($path_2);
                   $i->delete();
               }
           }

           $files = App\Files::doesntHave('files_pg_ars')->get();
           if(isset($files)&&count($files)!=0) {
               foreach ($files as $i) {
                   //  $file_path = public_path().'/storage/uploads/images/'.$i->path;
                   $path = public_path() . '/storage/uploads/files/' . date_create($i->created_at)->Format('Y_m') . '/' . $i->path;
                   File::delete($path);
                   // $file_path_2 = public_path().'/storage/uploads/images/small/'.$i->path;
                   $i->delete();
               }
           }

           Session::flash('success', 'Видалено успішно');
           return back()->with('message', 'Запис видален');
       }
        catch (\Exception $e){
        return back()->withError($e->getMessage())->withInput();
        }

    }

    public function map_edit(){
        try {
                $data = App\Maps::first();
                return view("admin_panel/maps/create", ['data' => $data]);

        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

        public function map_store(Request $request){
           try {
               $data = App\Maps::first();
               if (isset($data) == false) {
                   $data = new App\Maps;
               }
               $data->title = $request->title;
               $data->url = $request->url;
               $data->save();
               Session::flash('success', 'Змінено успішно');
               return redirect()->route('admin_panel.index')->with('message', 'Запис оновлен');
           }
           catch (\Exception $e){
               return back()->withError($e->getMessage())->withInput();
           }
        }

    public function store(Request $request)
    {

    }


    public function show($id)
    {

    }


    public function create()
    {

    }

    public function edit($id)
    {

    }


}
