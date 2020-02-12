<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{

    public function index(){
       try {
           $news = App\Articles::where('status', '=', true)->whereHas('type_articlesss', function ($query) {
               $query->where('name', 'Новина');
           })->whereHas('block_newsss', function ($query) {
               $query->orderBy('index_position', 'desc');
                })
               ->where(function ($q) {
                   $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
               })
              ->where(function ($q) {
                  $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                 })
               ->with('block_newsss')->join('block_news', 'articles.id', '=', 'block_news.id_articles')
               ->orderBy('block_news.index_position', 'asc')
               ->orderBy('articles.id', 'desc')
               ->take(8)->get();


           $n_date = date("y-m-d", strtotime("-14 days"));


           $anons = App\Articles::
               where(function ($q) use ($n_date) {
                $q->where('date_advice', '=', null)->whereRaw('created_at >= DATE_ADD(NOW(), INTERVAL -14 DAY)');
                $q->orWhereDate('date_advice', '>=', $n_date);
               })
               ->where('status', '=', true)
               ->whereHas('type_articlesss', function ($query) {
               $query->where('name', 'Анонс');
           })->orderBy('id', 'desc')->first();

           $roads = App\StanDorig::where('status', '=', true)
               ->where(function ($q) {
                   $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
               })
               ->where(function ($q) {
                   $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
               })
               ->orderBy('id', 'desc')->first();
           $maps = App\Maps::first();
           return view('index', ['news' => $news, 'anons' => $anons, 'roads' => $roads, 'maps' =>$maps]);
       }
       catch (\Exception $e){
           return back();
       }
    }


    public function search(Request $request){

        try {
            $title_search = $request->get('title_search', '');
          //  $title_search = $search;
            if (isset($title_search) && $title_search != '') {
                $data = App\Articles::where(function ($q) use ($title_search) {
                    $q->where('title', 'like', '%' . $title_search . '%');
                    $q->orWhere('body', 'like', '%' . $title_search . '%');
                })
                    ->where('status', true)
                    ->where(function ($q) {
                        $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                    })
                    ->where(function ($q) {
                        $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                    })
                    ->orderBy('id', 'desc')->paginate(2);

            }
            else{
                $data = App\Articles::where('status', '=', true)
                    ->where(function ($q) {
                        $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                    })
                    ->where(function ($q) {
                        $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                    })
                    ->orderBy('id', 'desc')->paginate(2);
                $title_search = " ";
            }
            //   $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);
            return view("public/catalog_search", ["catalog" => $data, 'search' => $title_search]);
        }

        catch (\Exception $e){
            return back();
        }
    }
}
