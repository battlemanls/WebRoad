<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Intervention\Image\Facades\Image;

class WebPagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkjurnalist', ['except' => ['show']]);
    }

    public function index(){
        try {
            $data = App\WebPages::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);
            return view("admin_panel/pages/catalog", ["data" => $data]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function show($id){
        try {
            $data = App\WebPages::find($id);
            return view('public/pages/show', ['data' => $data]);
        }
        catch (\Exception $e){
          /*  return back()->withError($e->getMessage())->withInput();*/
            return back();
        }
    }


    public function search(Request $request){
        try {
            $type_search = $request->type_search;
            $title_search = $request->title_search;
            if ($type_search == 'Все') { //Все
                if (isset($title_search) && $title_search != '') {
                    $data = App\WebPages::where('title', 'like', '%' . $title_search . '%')->orderBy('id', 'desc')->paginate(10);
                } else {

                    $data = App\WebPages::orderBy('id', 'desc')->paginate(10);
                }
            }

            if ($type_search == 'Скрытые') { //Скрытые
                if (isset($title_search) && $title_search != '') {
                    $data = App\WebPages::where('title', 'like', '%' . $title_search . '%')->where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
                } else {
                    // $date_now = date("y-m-d");
                    $data = App\WebPages::where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
                }
            }

            //   $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);

            return view("admin_panel/pages/catalog", ["data" => $data, 'type_search' => $type_search,
                "title_search" => $title_search
                ]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function create(){
        try {
            return view("admin_panel/pages/create");
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function edit($id){
        try {
            if (isset($id)) {
                $data = App\WebPages::find($id);
                return view("admin_panel/pages/create", ['data' => $data]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function store(Request $request){
        try {
            if (isset($request)) {
                $this->validate($request, [
                    'title' => 'required|max:191',
                ]);

                /* Считываем id файлов */
                if (isset($request->file) && $request->file != null) {
                    $string_files = $request->file;
                    $files = explode(",", $string_files);
                }

                /* Считываем id изображений */
                if (isset($request->image) && $request->image != null) {
                    $string_image = $request->image;
                    $images = explode(",", $string_image);
                }

                if (!isset($request->edit)) { //добавление страницы
                    $data = new App\WebPages;
                    $data->title = strip_tags(html_entity_decode($request->title));
                    //   $data->slug = $request->slug;
                   /* $data->excerpt = $request->excerpt;*/
                    $data->body = $request->body;
                    if (isset($array_path_img)) {
                        //    $data->img_gallery = json_encode($array_path_img);
                    }
                    //   $data->files = '';
                    $data->meta_description = $request->meta_description;
                    $data->meta_keywords = $request->meta_keywords;
                    if(isset($request->status)&&$request->status==true){
                        $data->status = false;
                    }
                    else{
                        $data->status = true;
                    }
                    $data->save();
                    $id_page = $data->id;

                    if (isset($files)) {
                        foreach ($files as $file) {
                            /*     $files_pg_ar = new App\FilesPgAr;
                                   $files_pg_ar->id_pages = $id_page;
                                   $files_pg_ar->id_files = $file;
                                   $files_pg_ar->save();  */

                            $files_pg_ar = App\FilesPgAr::create([
                                'id_pages' => $id_page,   // $request->title also works?
                                'id_files' => $file, // $request->body also works?
                                // there might be a better solution, but this works 100%
                            ]);
                        }
                    }

                    if (isset($images)) {
                        foreach ($images as $file) {
                            $files_pg_ar = new App\ImagesPgAr();
                            $files_pg_ar->id_pages = $id_page;
                            $files_pg_ar->id_images = $file;
                            $files_pg_ar->save();
                        }
                    }

                    return redirect()->route('admin_panel.pages.catalog')->with('message', 'Запис додан');

                } else { //Редактирование страницы

                    $data = App\WebPages::find($request->id);
                    $data->title = strip_tags(html_entity_decode($request->title));
                    //  $data->slug = $request->slug;
                  /*  $data->excerpt = $request->excerpt;*/
                    $data->body = $request->body;
                    if (isset($array_path_img)) {
                        //    $data->img_gallery = json_encode($array_path_img);
                    }
                    //  $data->files = '';
                    $data->meta_description = $request->meta_description;
                    $data->meta_keywords = $request->meta_keywords;
                    if(isset($request->status)&&$request->status==true){
                        $data->status = false;
                    }
                    else{
                        $data->status = true;
                    }
                    $data->save();
                    $id_page = $data->id;


                    if (isset($files)) {
                        foreach ($files as $file) {
                            $files_pg_ar = new App\FilesPgAr();
                            $files_pg_ar->id_pages = $id_page;
                            $files_pg_ar->id_files = $file;
                            $files_pg_ar->save();
                        }
                    }

                    if (isset($images)) {
                        foreach ($images as $file) {
                            $files_pg_ar = new App\ImagesPgAr();
                            $files_pg_ar->id_pages = $id_page;
                            $files_pg_ar->id_images = $file;
                            $files_pg_ar->save();
                        }
                    }
                    return redirect()->route('admin_panel.pages.catalog')->with('message', 'Запис оновлен');
                }
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function destroy($id){
        try {
            if (isset($id)) {
                $files_p_a = App\FilesPgAr::where('id_pages', $id)->get();
                $files = App\Files::whereHas('files_pg_ars', function ($query) use ($id) {
                    $query->where('id_pages', $id);
                })->get();

                $img_p_a = App\ImagesPgAr::where('id_pages', $id)->get();
                $images = App\Images::whereHas('files_pg_ars', function ($query) use ($id) {
                    $query->where('id_pages', $id);
                })->get();

                $data = App\WebPages::find($id);
                if (isset($data)) {
                    foreach ($files_p_a as $fpa){
                        $fpa->delete();
                    }
                    foreach ($files as $f){
                        $file_path = public_path().'/storage/uploads/files/'.$f->path;
                        File::delete($file_path);
                        $f->delete();
                    }
                    foreach ($img_p_a as $ipa){
                        $ipa->delete();
                    }
                    foreach ($images as $i){
                        $file_path = public_path().'/storage/uploads/images/'.$i->path;
                        File::delete($file_path);
                        $file_path_2 = public_path().'/storage/uploads/images/small/'.$i->path;
                        File::delete($file_path_2);
                        $i->delete();
                    }
                    $data->delete();
                    Session::flash('success', 'Видалено успішно');
                    return redirect()->route('admin_panel.pages.catalog')->with('message', 'Запис видален');
                }
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

}


