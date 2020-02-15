<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class SiteController extends Controller
{

   //Pro_DP
            public function contact(){
                try {
                    $page = App\WebPages::find(5);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function opis(){
                try {
                    $page = App\WebPages::find(7);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function osnovni_zavdanna(){
                try {
                    $page = App\WebPages::find(8);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();

                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function rozporadok_roboti(){
                try {
                    $page = App\WebPages::find(9);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function vakansii(){
                try {
                    $page = App\WebPages::find(10);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

    //Pres_Center
            public function novini(){
                try {
                    $page = App\WebPages::find(11);
                    $articles = App\Articles::where('status', '=', true)->whereHas('type_articlesss', function ($query) {
                        $query->where('name', 'Новина');
                    })
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->paginate(8);
                    return view('public/articles/catalog', ['data' => $page, 'catalog' => $articles]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function anonsi(){
                try {
                    $page = App\WebPages::find(12);
                    $articles = App\Articles::where('status', '=', true)->whereHas('type_articlesss', function ($query) {
                        $query->where('name', 'Анонс');
                    })
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->paginate(10);
                    return view('public/articles/catalog', ['data' => $page, 'catalog' => $articles]);
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function photo_galerea(){
                try {
                    $images = App\Articles::whereHas('images_pg_ars', function ($query) {
                        $query->orderBy('id', 'desc');
                    })
                        ->where(function ($q) {
                        $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                    })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })->where('status','=', true)->paginate(5);
                    return view('public/gallery', ['data' => $images]);

/*
                    $page = App\WebPages::find(13);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);*/
                }
                catch (\Exception $e){
                    return back();
                }
            }

            public function video_galerea(){
                try {
                   return redirect("https://www.youtube.com/channel/UCRa_7n3VA6D1A_GzF4JSNZw");
                /*    $page = App\WebPages::find(14);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                */
                }
                catch (\Exception $e){
                    return back();
                }
            }

    //Dialnist
        public function vikonani_zahodi(){
                try {
                    $page = App\WebPages::find(15);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

      /*  public function dorozni_roboti(){
                try {
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    $page = App\WebPages::find(16);
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }*/

    /*    public function likvidacia_amkovosti(){
                try {
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    $page = App\WebPages::find(17);
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }*/

        public function zaplanovani_roboti(){
                try {
                    $page = App\WebPages::find(18);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

        public function sfera(){
                try {
                    $page = App\WebPages::find(19);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

        public function finansovo_economichna_dialnist(){
                try {
                    $page = App\WebPages::find(20);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

        public function derzavni_zakupivli(){
                try {
                    $page = App\WebPages::find(21);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

        //Normativna_baza
        public function ogoloshena(){
                try {
                    $page = App\WebPages::find(22);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();

                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

        public function rozporadjena(){
                try {
                    $page = App\WebPages::find(23);
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/pages/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
        }

    //RegionRoad
        public function road($type, $region){
                try {
                    $page = App\Roads::whereHas('type_roads', function ($query) use ($type) {
                        $query->where('name', $type);
                    })->whereHas('regions', function ($query) use ($region) {
                        $query->where('name', $region);
                    })->first();
                    $articles_more = App\Articles::where('status', '=', true)
                        ->where(function ($q) {
                            $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                        })
                        ->where(function ($q) {
                            $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                        })
                        ->orderBy('id', 'desc')->take(10)->get();
                    return view('public/roads/show', ['data' => $page, 'articles_more' => $articles_more]);
                }
                catch (\Exception $e){
                    return back();
                }
    }
}
