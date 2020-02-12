<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ArticlesController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkjurnalist', ['except' => ['show']]);
    }


    public function index()
    {
        try {
            $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);
            return view("admin_panel/articles/catalog", ["data" => $data]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function show($id)
    {
        try {
            $data = App\Articles::find($id);
            $articles_more = App\Articles::where('status', '=', true)
                ->where('id', '!=', $id)
                ->where(function ($q) {
                    $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                })
                ->where(function ($q) {
                    $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                })
                ->orderBy('id', 'desc')->take(10)->get();

            if($data->status==0){
                if(isset(Auth::user()->id)){
                    return view('public/articles/show', ['data' => $data]);
                }
                else{
                    return back()->withError('Немає доступу');
                }
            }
            else {

                return view('public/articles/show', ['data' => $data, 'articles_more' => $articles_more]);
            }
        }
        catch (\Exception $e){
           // return back()->withError($e->getMessage())->withInput();
            return back();
        }
    }


    public function pre_show($id)
    {
        try {
            $data = App\Articles::find($id);

                if(isset(Auth::user()->id)){
                    return view('admin_panel/articles/pre_show', ['data' => $data]);
                }
                else{
                    return back()->withError('Немає доступу');
                }

        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function confirm(Request $request)
    {
        try {
            if (isset($request->id)) {
            $data = App\Articles::find($request->id);
            $data->status = true;
            $data->save();
            $catalog = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);
            return view("admin_panel/articles/catalog", ["data" => $catalog]);
            }
            else{
                return back()->withError("Ошибка");
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function search(Request $request){
       try {
           $type_search = $request->type_search;
           $title_search = $request->title_search;
           if ($type_search == 'Все') { //Все
               if (isset($title_search) && $title_search != '') {
                   $data = App\Articles::where('title', 'like', '%' . $title_search . '%')->orderBy('id', 'desc')->paginate(10);
               } else {
                   $data = App\Articles::orderBy('id', 'desc')->paginate(10);
               }
           }

           if ($type_search == 'Новости') { //Новости
               if (isset($title_search) && $title_search != '') {
                   $data = App\Articles::where('title', 'like', '%' . $title_search . '%')->whereHas('type_articlesss', function ($query) {
                       $query->where('name', 'Новина');
                   })->orderBy('id', 'desc')->paginate(10);
               } else {
                   $data = App\Articles::whereHas('type_articlesss', function ($query) {
                       $query->where('name', 'Новина');
                   })->orderBy('id', 'desc')->paginate(10);
               }
           }

           if ($type_search == 'Анонсы') { //Анонсы
               if (isset($title_search) && $title_search != '') {
                   $data = App\Articles::where('title', 'like', '%' . $title_search . '%')->whereHas('type_articlesss', function ($query) {
                       $query->where('name', 'Анонс');
                   })->orderBy('id', 'desc')->paginate(10);
               } else {
                   $data = App\Articles::whereHas('type_articlesss', function ($query) {
                       $query->where('name', 'Анонс');
                   })->orderBy('id', 'desc')->paginate(10);
               }

           }

           if ($type_search == 'Скоро опубликуются') { //Скоро опубликуются
               if (isset($title_search) && $title_search != '') {
                   $date_now = date("y-m-d");
                   $data = App\Articles::where('title', 'like', '%' . $title_search . '%')->where('date_advice', '>', $date_now)->orderBy('id', 'desc')->paginate(10);
               } else {
                   // $date_now = date("y-m-y H:i:s");
                   $date_now = date("y-m-d");
                   $data = App\Articles::where('date_advice', '>', $date_now)->orderBy('id', 'desc')->paginate(10);
               }
           }

           if ($type_search == 'Временные (уже скрытые)') { //Временные (уже скрытые)
               if (isset($title_search) && $title_search != '') {
                   $date_now = date("y-m-d");
                   $data = App\Articles::where('title', 'like', '%' . $title_search . '%')->where('date_advice_end', '<', $date_now)->orderBy('id', 'desc')->paginate(10);
               } else {
                   $date_now = date("y-m-d");
                   $data = App\Articles::where('date_advice_end', '<', $date_now)->orderBy('id', 'desc')->paginate(10);
               }
           }

           if ($type_search == 'Скрытые') { //Скрытые
               if (isset($title_search) && $title_search != '') {
                   $data = App\Articles::where('title', 'like', '%' . $title_search . '%')->where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
               } else {
                   // $date_now = date("y-m-d");
                   $data = App\Articles::where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
               }
           }

           //   $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);

           return view("admin_panel/articles/catalog", ["data" => $data,
               'type_search' => $type_search,
               "title_search" => $title_search,
               ]);
       }
       catch (\Exception $e){
           return back()->withError($e->getMessage())->withInput();
        }
    }

    public function create()
    {
        try {
            $type = App\TypeArticles::all();
            return view("admin_panel/articles/create", ['type' => $type]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        try {
            if (isset($id)) {
                $data = App\Articles::find($id);
                $type = App\TypeArticles::all();
                $on_main = App\BlockNews::where('id_articles', $id)->first();

                return view("admin_panel/articles/create", ['data' => $data, 'type' => $type, 'on_main' => $on_main]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }

    public function store(Request $request)
    {
        try {
            $date_directory = null;
            $filename = '';
            if (isset($request)) {
                $this->validate($request, [
                    'title' => 'required|max:191',
                    'body' => 'required',
                    'excerpt' => 'max:1000',
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

               // Считываем обложку и редактируем ее
                if (isset($request->img_avatar)) {
                    $image = $request->img_avatar;
                    $avatarName = $image->getClientOriginalName();
                    $filename = $avatarName . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $small_img = Image::make($image->path())->orientate();
                    $big_image = Image::make($image->path())->orientate();
                    $small_img->resize(800, 600, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                /*    $big_image->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });*/
                }

                if (!isset($request->edit)) { //добавление страницы
                        $data = new App\Articles;
                        $data->title = strip_tags(html_entity_decode($request->title));
                        $data->body = $request->body;
                        $url_youtube = $request->youtube;
                        $url_youtube = str_replace("watch?v=", "embed/", $url_youtube);
                        $url_youtube = str_replace("youtu.be/", "www.youtube.com/embed/", $url_youtube);
                        $data->youtube = $url_youtube;
                        //$data->excerpt = $request->excerpt;
                        $data->excerpt = strip_tags(html_entity_decode($request->excerpt));
                        if (isset($request->img_avatar)) {
                            $data->img_avatar = $filename;
                        }
                        $data->date_advice = $request->date_advice;
                        $data->date_advice_end = $request->date_advice_end;

                        $data->id_user = Auth::user()->id;
                        $data->id_type = $request->id_type;

                        $data->meta_description = $request->meta_description;
                        $data->meta_keywords = $request->meta_keywords;

                        if(isset($request->status)&&$request->status == true){
                            $data->status = false;
                        }
                        else {
                            $data->status = true;
                        }

                        $data->save();

                        //Сохраняем обложку на диске
                        if (isset($request->img_avatar)) {
                            $date_directory = date_create($data->created_at)->Format('Y_m');
                            if ($date_directory != null) {
                                $path = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/';
                                $path_2 = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/';
                                File::makeDirectory($path, $mode = 0777, true, true);
                                File::makeDirectory($path_2, $mode = 0777, true, true);
                                $pt_small = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/' . $filename);
                                $pt_big = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/' . $filename);

                                $small_img->save($pt_small);
                                $big_image->save($pt_big);
                            }
                        }

                        if(isset($request->on_main)&& $request->on_main == true && isset($data->id)){
                            $data_2 = new App\BlockNews;
                            $data_2->id_articles = $data->id;
                            $data_2->index_position = 0;
                            $data_2->save();
                        }

                        $id_page = $data->id;

                        if (isset($files)) {
                            foreach ($files as $file) {
                                /*     $files_pg_ar = new App\FilesPgAr;
                                       $files_pg_ar->id_pages = $id_page;
                                       $files_pg_ar->id_files = $file;
                                       $files_pg_ar->save();*/
                                $files_pg_ar = App\FilesPgAr::create([
                                    'id_articles' => $id_page,
                                    'id_files' => $file,
                                ]);
                            }
                        }

                        if (isset($images)) {
                            foreach ($images as $file) {
                                $files_pg_ar = new App\ImagesPgAr();
                                $files_pg_ar->id_articles = $id_page;
                                $files_pg_ar->id_images = $file;
                                $files_pg_ar->save();
                            }
                        }

                        if($request->status==true){
                            Session::flash('success', 'Попередній перегляд');
                            return redirect()->route('admin_panel.articles.pre_show', [$data->id])->with('message', 'Попередній перегляд');
                        }
                        else {
                            Session::flash('success', 'Додано успішно');
                            return redirect()->route('admin_panel.articles.catalog')->with('message', 'Запис додан');
                        }


                } else { //Редактирование страницы

                    $data = App\Articles::find($request->id);
                    $date_directory = date_create($data->created_at)->Format('Y_m');
                    $data->title = strip_tags(html_entity_decode($request->title));
                    $data->body = $request->body;
                    $url_youtube = $request->youtube;
                    $url_youtube = str_replace("watch?v=", "embed/", $url_youtube);
                    $url_youtube = str_replace("youtu.be/", "www.youtube.com/embed/", $url_youtube);
                    $data->youtube = $url_youtube;
                   // $data->excerpt = $request->excerpt;
                    $data->excerpt = strip_tags(html_entity_decode($request->excerpt));

                    //Удаляем прошлую обложку
                    if (isset($request->img_avatar)) {
                        $date_directory_old = date_create($data->created_at)->Format('Y_m');
                        $file_path_3 = public_path().'/storage/uploads/images/'. $date_directory_old . '/'. 'avatar/'. 'big/' .$data->img_avatar;
                        File::delete($file_path_3);
                        $file_path_4 = public_path().'/storage/uploads/images/'. $date_directory_old . '/'. 'avatar/'. 'small/' .$data->img_avatar;
                        File::delete($file_path_4);
                        $data->img_avatar = $filename;
                    }

                    $data->date_advice = $request->date_advice;
                    $data->date_advice_end = $request->date_advice_end;
                    $data->id_user = Auth::user()->id;
                    $data->id_type = $request->id_type;
                    $data->meta_description = $request->meta_description;
                    $data->meta_keywords = $request->meta_keywords;

                    if(isset($request->status)&&$request->status == true){
                        $data->status = false;
                    }
                    else {
                        $data->status = true;
                    }
                    $data->save();

                    $data_2 = App\BlockNews::where('id_articles', $request->id)->first();

                    if(isset($data_2->id_articles)&&$request->on_main==false){
                        $data_2->delete();
                    }
                    else
                        if(!isset($data_2->id_articles) && $request->on_main==true){
                        $data_2 = new App\BlockNews();
                        $data_2->id_articles = $request->id;
                        $data_2->index_position = 0;
                        $data_2->save();
                    }

                    $id_page = $data->id;
                    if (isset($files)) {
                        foreach ($files as $file) {
                            $files_pg_ar = new App\FilesPgAr();
                            $files_pg_ar->id_articles = $id_page;
                            $files_pg_ar->id_files = $file;
                            $files_pg_ar->save();
                        }
                    }

                    if (isset($images)) {
                        foreach ($images as $file) {
                            $files_pg_ar = new App\ImagesPgAr();
                            $files_pg_ar->id_articles = $id_page;
                            $files_pg_ar->id_images = $file;
                            $files_pg_ar->save();
                        }
                    }

                    if (isset($request->img_avatar)) {
                        $date_directory = date_create($data->created_at)->Format('Y_m');

                        if ($date_directory != null) {
                            $path = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/';
                            $path_2 = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/';
                            File::makeDirectory($path, $mode = 0777, true, true);
                            File::makeDirectory($path_2, $mode = 0777, true, true);
                            $pt_small = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/' . $filename);
                            $pt_big = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/' . $filename);

                            $small_img->save($pt_small);
                            $big_image->save($pt_big);
                        }
                    }

                    if($request->status==true){
                        Session::flash('success', 'Попередній перегляд');
                        return redirect()->route('admin_panel.articles.pre_show', [$data->id])->with('message', 'Попередній перегляд');
                    }
                    else {
                        Session::flash('success', 'Змінено успішно');
                        return redirect()->route('admin_panel.articles.catalog')->with('message', 'Запис оновлен');
                    }

                }
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            if (isset($id)) {
                $files_p_a = App\FilesPgAr::where('id_articles', $id)->get();
                $files = App\Files::whereHas('files_pg_ars', function ($query) use ($id) {
                    $query->where('id_articles', $id);
                })->get();

                $img_p_a = App\ImagesPgAr::where('id_articles', $id)->get();
                $images = App\Images::whereHas('files_pg_ars', function ($query) use ($id) {
                    $query->where('id_articles', $id);
                })->get();

                $block_main = App\BlockNews::where('id_articles', $id)->get();

                $data = App\Articles::find($id);
                if (isset($data)) {
                    foreach ($files_p_a as $fpa){
                        $fpa->delete();
                    }

                    foreach ($files as $f){
                       // Storage::delete(asset($f->path));
                        $path = public_path() . '/storage/uploads/files/' . date_create($f->created_at)->Format('Y_m') . '/' . $f->path;
                      //  $file_path = public_path().'/storage/uploads/files/'.$f->path;
                        File::delete($path);
                        $f->delete();
                    }

                    foreach ($img_p_a as $ipa){
                        $ipa->delete();
                    }

                    foreach ($images as $i){
                      //  $file_path = public_path().'/storage/uploads/images/'.$i->path;
                        $path =  public_path().'/storage/uploads/images/'. date_create($i->created_at)->Format('Y_m') . '/'. 'gallery/'. 'big/' . $i->path;
                        $path_2 = public_path().'/storage/uploads/images/'. date_create($i->created_at)->Format('Y_m') . '/'. 'gallery/'. 'small/' . $i->path;
                        File::delete($path);
                       // $file_path_2 = public_path().'/storage/uploads/images/small/'.$i->path;
                        File::delete($path_2);
                        $i->delete();
                    }

                    if($block_main!=null){
                    foreach ($block_main as $bm){
                        $bm->delete();
                    }}

                    $date_directory_old = date_create($data->created_at)->Format('Y_m');
                    $file_path_3 = public_path().'/storage/uploads/images/'. $date_directory_old . '/'. 'avatar/'. 'big/' .$data->img_avatar;
                    File::delete($file_path_3);
                    $file_path_4 = public_path().'/storage/uploads/images/'. $date_directory_old . '/'. 'avatar/'. 'small/' .$data->img_avatar;
                    File::delete($file_path_4);
                    $data->delete();
                    Session::flash('success', 'Видалено успішно');
                    return redirect()->route('admin_panel.articles.catalog')->with('message', 'Запис видален');
                }

            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

}
