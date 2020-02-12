<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class StanDorigController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkjurnalist');
    }


    public function index()
    {
        try {
            $data = App\StanDorig::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);

            return view("admin_panel/stan_dorig/catalog", ["data" => $data]);
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
                    $data = App\StanDorig::where('title', 'like', '%' . $title_search . '%')->orderBy('id', 'desc')->paginate(10);
                } else {
                    $data = App\StanDorig::orderBy('id', 'desc')->paginate(10);
                }
            }


            if ($type_search == 'Скоро опубликуются') { //Скоро опубликуются
                if (isset($title_search) && $title_search != '') {
                    $date_now = date("y-m-d");
                    $data = App\StanDorig::where('title', 'like', '%' . $title_search . '%')->where('date_advice', '>', $date_now)->orderBy('id', 'desc')->paginate(10);
                } else {
                    $date_now = date("y-m-d");
                    $data = App\StanDorig::where('date_advice', '>', $date_now)->orderBy('id', 'desc')->paginate(10);
                }
            }
            if ($type_search == 'Временные (уже скрытые)') { //Временные (уже скрытые)
                if (isset($title_search) && $title_search != '') {
                    $date_now = date("y-m-d");
                    $data = App\StanDorig::where('title', 'like', '%' . $title_search . '%')->where('date_advice_end', '<', $date_now)->orderBy('id', 'desc')->paginate(10);
                } else {
                    $date_now = date("y-m-d");
                    $data = App\StanDorig::where('date_advice_end', '<', $date_now)->orderBy('id', 'desc')->paginate(10);
                }
            }

            if ($type_search == 'Скрытые') { //Скрытые
                if (isset($title_search) && $title_search != '') {
                    $data = App\StanDorig::where('title', 'like', '%' . $title_search . '%')->where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
                } else {
                    $data = App\StanDorig::where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
                }
            }
            //   $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);
            return view("admin_panel/stan_dorig/catalog", ["data" => $data, 'type_search' => $type_search,
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
            /*$type = App\TypeArticles::all();*/
            return view("admin_panel/stan_dorig/create");
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }


    public function edit($id)
    {
        try {
            if (isset($id)) {
                $data = App\StanDorig::find($id);
                /* $type = App\TypeArticles::all();*/
                return view("admin_panel/stan_dorig/create", ['data' => $data]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function store(Request $request)
    {
        try {
           /* $date_directory = date("Y_m");*/
            $date_directory = null;
            $filename = '';
            if (isset($request)) {
                $this->validate($request, [
                    'title' => 'required|max:191',
                ]);

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
                }

                if (!isset($request->edit)) { //добавление страницы
                    $data = new App\StanDorig();
                    $data->title = strip_tags(html_entity_decode($request->title));
                    /*  $data->body = $request->body;*/
                    $data->url = $request->url;
                    if (isset($request->img_avatar)) {
                        $data->img_avatar = $filename;
                    }
                    $data->date_advice = $request->date_advice;
                    $data->date_advice_end = $request->date_advice_end;
                    $data->id_user = Auth::user()->id;
                    if(isset($request->status)&&$request->status==true){
                        $data->status = false;
                    }
                    else{
                        $data->status = true;
                    }
                    $data->save();

                    if (isset($request->img_avatar)) {
                        $date_directory = date_create($data->created_at)->Format('Y_m');
                        if ($date_directory != null) {
                            $path = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/';
                            $path_2 = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/';
                            File::makeDirectory($path, $mode = 0777, true, true);
                            File::makeDirectory($path_2, $mode = 0777, true, true);
                            $pt_small = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/' . $filename);
                            $pt_big = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/' . $filename);
                            /*  $pt_small = public_path('storage/uploads/images/articles_avatar/small/' . $filename);
                              $pt_big = public_path('storage/uploads/images/articles_avatar/' . $filename);*/

                            $small_img->save($pt_small);
                            $big_image->save($pt_big);
                        }
                    }
                    Session::flash('success', 'Додано успішно');
                    return redirect()->route('admin_panel.stan_dorig.catalog')->with('message', 'Запис додан');

                } else { //Редактирование страницы
                    $data = App\StanDorig::find($request->id);
                    $data->title = strip_tags(html_entity_decode($request->title));
                    /* $data->body = $request->body;*/
                    $data->url = $request->url;
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
                    if(isset($request->status)&&$request->status==true){
                        $data->status = false;
                    }
                    else{
                        $data->status = true;
                    }
                    $data->save();

                    if (isset($request->img_avatar)) {
                        $date_directory = date_create($data->created_at)->Format('Y_m');

                        if ($date_directory != null) {
                            $path = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/';
                            $path_2 = public_path() . '/storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/';
                            File::makeDirectory($path, $mode = 0777, true, true);
                            File::makeDirectory($path_2, $mode = 0777, true, true);
                            $pt_small = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'small/' . $filename);
                            $pt_big = public_path('storage/uploads/images/' . $date_directory . '/' . 'avatar/' . 'big/' . $filename);
                            /*  $pt_small = public_path('storage/uploads/images/articles_avatar/small/' . $filename);
                              $pt_big = public_path('storage/uploads/images/articles_avatar/' . $filename);*/

                            $small_img->save($pt_small);
                            $big_image->save($pt_big);
                        }
                    }
                    Session::flash('success', 'Змінено успішно');
                    return redirect()->route('admin_panel.stan_dorig.catalog')->with('message', 'Запис оновлен');
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
                $data = App\StanDorig::find($id);
                $date_directory_old = date_create($data->created_at)->Format('Y_m');
                $file_path_3 = public_path().'/storage/uploads/images/'. $date_directory_old . '/'. 'avatar/'. 'big/' .$data->img_avatar;
                File::delete($file_path_3);
                $file_path_4 = public_path().'/storage/uploads/images/'. $date_directory_old . '/'. 'avatar/'. 'small/' .$data->img_avatar;
                File::delete($file_path_4);
             /*   $file_path_3 = public_path().'/storage/uploads/images/articles_avatar/'.$data->img_avatar;
                File::delete($file_path_3);
                $file_path_4 = public_path().'/storage/uploads/images/articles_avatar/small/'.$data->img_avatar;
                File::delete($file_path_4);*/
                if (isset($data)) {
                    $data->delete();
                    Session::flash('success', 'Видалено успішно');
                    return redirect()->route('admin_panel.stan_dorig.catalog')->with('message', 'Запис видален');
                }
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

}
