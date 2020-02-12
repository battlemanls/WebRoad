<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
//use Session;

class BlocknewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkjurnalist');
    }


    public function index()
    {
        try {
            $block_news = App\Articles::whereHas('block_newsss', function ($query) {
                $query->orderBy('index_position', 'desc');
            })->whereHas('type_articlesss', function ($query) {
                $query->where('name', 'Новина');
            })->paginate(10);
            $data = App\Articles::doesntHave('block_newsss')->whereHas('type_articlesss', function ($query) {
                $query->where('name', 'Новина');
            })->orderBy('id', 'desc')->where('status', '=', true)->paginate(10);
            return view("admin_panel/articles/block_news_control", ['data' => $data, "block_news" => $block_news]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function add(Request $request)
    {
        if ($request->ajax()) {
            try {
                $id = $request->input("id_article");
                $data = new App\BlockNews;
                $data->id_articles = $id;
                $data->index_position = 0;
                $data->save();
             /*  Session::flash('success', 'Добавлено успешно');*/
               $data = App\Articles::doesntHave('block_newsss')->whereHas('type_articlesss', function ($query) {
                   $query->where('name', 'Новина');
               })->orderBy('id', 'desc')->paginate(10);
               $block_news = App\Articles::whereHas('block_newsss', function ($query) {
                    $query->orderBy('index_position', 'desc');
                })->whereHas('type_articlesss', function ($query) {
                   $query->where('name', 'Новина');
               })->paginate(10);
             //  $message=$block_news;
             //   return response()->json(compact('html', 'message'));

               $message = view('ajax_flash/flash_error')->render();
               $html = view('admin_panel/articles/block_news_control__table_article', ['data' => $data])->render();
               $html2 = view('admin_panel/articles/block_news_control__table_position', ['block_news' => $block_news])->render();
               /* $message=$html2;*/
                Session::flash('success', 'Додано успішно');
                return response()->json(compact('html', 'html2', 'message'));
            }
            catch (Exception $e){
                Session::flash('error', 'Уже сущесвует');
                $message = view('ajax_flash/flash_error')->render();
                return response()->json(compact('html', 'message'));
            }
            }

        }

    public function edit(Request $request){
        if ($request->ajax()) {
            $messages = $request->input("id_article");
            $id=$request->input("id_article");
            $index_position = $request->input("index_position");
            $data = App\BlockNews::where('id_articles', $id)->first();
            $data->index_position = $index_position;
            $data->save();
            $message = "Успешно добавлено";
            Session::flash('success', 'Додано успішно');
            return response()->json(compact('html', 'message'));
        }
    }


    public function search(Request $request){
        try {
            $type_search = $request->type_search;
            $title_search = $request->title_search;
            if ($type_search == 'Все') { //Все
                if (isset($title_search) && $title_search != '') {
                    $data = App\Articles::doesntHave('block_newsss')->where('title', 'like', '%' . $title_search . '%')->whereHas('type_articlesss', function ($query) {
                        $query->where('name', 'Новина');
                    })->orderBy('id', 'desc')->paginate(10);
                } else {
                    $data = App\Articles::doesntHave('block_newsss')->whereHas('type_articlesss', function ($query) {
                        $query->where('name', 'Новина');
                    })->orderBy('id', 'desc')->paginate(10);
                }
            }

            if ($type_search == 'Скоро опубликуются') { //Скоро опубликуются
                if (isset($title_search) && $title_search != '') {
                    $date_now = date("y-m-d");
                    $data = App\Articles::doesntHave('block_newsss')->where('title', 'like', '%' . $title_search . '%')->where('date_advice', '>', $date_now)->orderBy('id', 'desc')->paginate(10);
                } else {
                    // $date_now = date("y-m-y H:i:s");
                    $date_now = date("y-m-d");
                    $data = App\Articles::doesntHave('block_newsss')->where('date_advice', '>', $date_now)->orderBy('id', 'desc')->paginate(10);
                }
            }
            if ($type_search == 'Временные (уже скрытые)') { //Временные (уже скрытые)
                if (isset($title_search) && $title_search != '') {
                    $date_now = date("y-m-d");
                    $data = App\Articles::doesntHave('block_newsss')->where('title', 'like', '%' . $title_search . '%')->where('date_advice_end', '<', $date_now)->orderBy('id', 'desc')->paginate(10);
                } else {
                    $date_now = date("y-m-d");
                    $data = App\Articles::doesntHave('block_newsss')->where('date_advice_end', '<', $date_now)->orderBy('id', 'desc')->paginate(10);
                }
            }

            if ($type_search == 'Скрытые') { //Скрытые
                if (isset($title_search) && $title_search != '') {
                    $data = App\Articles::doesntHave('block_newsss')->where('title', 'like', '%' . $title_search . '%')->where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
                } else {
                    // $date_now = date("y-m-d");
                    $data = App\Articles::doesntHave('block_newsss')->where('status', '=', false)->orderBy('id', 'desc')->paginate(10);
                }
            }

            $block_news = App\Articles::whereHas('block_newsss', function ($query) {
                $query->orderBy('index_position', 'desc');
            })->whereHas('type_articlesss', function ($query) {
                $query->where('name', 'Новина');
            })->paginate(10);

            //   $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);

            return view("admin_panel/articles/block_news_control", ['data' => $data,
                "block_news" => $block_news,
                "title_search" => $title_search,
                "type_search" => $type_search


                ]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }



    public function delete( $id){
        try {
            if (isset($id)) {
                $data = App\BlockNews::where('id_articles', $id);
                $data->delete();
                return redirect()->route('admin_panel.blocknews.index')->with('message', 'Запис видален');
            }


            Session::flash('success', 'Видалено успішно');

        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }


    }








}
