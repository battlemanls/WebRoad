<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('index');
});*/

Route::get('/', 'IndexController@index')->name("site.index");
//Route::post('/search', ['uses' => 'IndexController@search'])->name("site.search");
Route::get('/search',['uses' => 'IndexController@search'])->name("site.search");


//Voyager
   // Route::get('/admin_panel/pro', 'WebPagesController@index')->name("admin_panel.pro.index");
    Route::group(['prefix' => 'admin_panel/pro', 'middleware' => 'auth'], function () {
    Voyager::routes();
    });


//Auth
    Auth::routes([
        'register' => false,
        'verify' => true,
        'reset' => false
    ]);


/*  Route::get('/home', 'HomeController@index')->name('home');*/



//WebPagesController
    Route::get('/admin_panel/pages/catalog', ['middleware' => 'auth', 'uses' =>'WebPagesController@index'])->name("admin_panel.pages.catalog");
    Route::post('/admin_panel/pages/store', ['middleware' => 'auth', 'uses' =>  'WebPagesController@store'])->name("admin_panel.pages.store");
    Route::delete('/admin_panel/pages/delete/{id}', ['middleware' => 'auth', 'uses' =>  'WebPagesController@store'])->name("admin_panel.pages.delete");
    Route::get('admin_panel/show/{id}', ['middleware' => 'auth', 'uses' =>  'WebPagesController@show'])->name("web.pages.show");
    Route::get('/admin_panel/pages/create', ['middleware' => 'auth', 'uses' =>  'WebPagesController@create'])->name("admin_panel.pages.create");
    Route::get('/admin_panel/pages/edit/{id}', ['middleware' => 'auth', 'uses' => 'WebPagesController@edit'])->name("admin_panel.pages.edit");
    Route::post('/admin_panel/pages/catalog', ['middleware' => 'auth', 'uses' => 'WebPagesController@search'])->name("admin_panel.pages.catalog.search");


//Files
    Route::get('files/image','FilesController@index');
    Route::post('files/store', ['middleware' => 'auth', 'uses' => 'FilesController@store'])->name('files/store');
    Route::post('files/delete', ['middleware' => 'auth', 'uses' => 'FilesController@destroy'])->name('files/delete');

//Images
    Route::get('images/image','ImagesController@index');
    Route::post('images/store', ['middleware' => 'auth', 'uses' => 'ImagesController@store'])->name('images/store');
    Route::post('images/delete', ['middleware' => 'auth', 'uses' => 'ImagesController@destroy'])->name('images/delete');


//ArticlesController
    Route::get('/admin_panel/articles/catalog', ['middleware' => 'auth', 'uses' => 'ArticlesController@index'])->name("admin_panel.articles.catalog");
    Route::post('/admin_panel/articles/store', ['middleware' => 'auth', 'uses' => 'ArticlesController@store'])->name("admin_panel.articles.store");
    Route::delete('/admin_panel/articles/delete/{id}',['middleware' => 'auth', 'uses' =>  'ArticlesController@destroy'])->name("admin_panel.articles.delete");
    Route::get('articles/show/{id}', [ 'uses' => 'ArticlesController@show'])->name("articles.show");
    Route::get('admin_panel/articles/pre_show/{id}', ['middleware' => 'auth', 'uses' =>  'ArticlesController@pre_show'])->name("admin_panel.articles.pre_show");
    Route::get('/admin_panel/articles/create', ['middleware' => 'auth', 'uses' => 'ArticlesController@create'])->name("admin_panel.articles.create");
    Route::get('/admin_panel/articles/edit/{id}', ['middleware' => 'auth', 'uses' => 'ArticlesController@edit'])->name("admin_panel.articles.edit");
    Route::post('/admin_panel/articles/catalog', ['middleware' => 'auth', 'uses' => 'ArticlesController@search'])->name("admin_panel.articles.catalog.search");
    Route::post('/admin_panel/articles/confirm', ['middleware' => 'auth', 'uses' => 'ArticlesController@confirm'])->name("admin_panel.articles.confirm");

//Admin_advice
    Route::get('/admin_panel/index', ['middleware' => 'auth', 'uses' => 'AdminController@index'])->name("admin_panel.index");
    Route::get('/admin_panel/', ['middleware' => 'auth', 'uses' => 'AdminController@index'])->name("admin_panel.index");
    Route::get('/admin_panel/delete_trash', ['middleware' => 'auth', 'uses' => 'AdminController@delete_trash'])->name("admin_panel.delete_trash");
    Route::get('/admin_panel/map/edit', ['middleware' => 'auth', 'uses' => 'AdminController@map_edit'])->name("admin_panel.maps.edit");
    Route::post('/admin_panel/map/store', ['middleware' => 'auth', 'uses' => 'AdminController@map_store'])->name("admin_panel.maps.store");


   //Pro_DP
    Route::get('/pro_dp/structura_contacti', 'SiteController@contact')->name("site.contact");
    Route::get('/pro_dp/opis', 'SiteController@opis')->name("site.opis");
    Route::get('/pro_dp/osnovni_zavdanna', 'SiteController@osnovni_zavdanna')->name("site.osnovni_zavdanna");
    Route::get('/pro_dp/rozporadok_roboti', 'SiteController@rozporadok_roboti')->name("site.rozporadok_roboti");
    Route::get('/pro_dp/vakansii', 'SiteController@vakansii')->name("site.vakansii");


    //Pres_centr
    Route::get('/pres_centr/novini', 'SiteController@novini')->name("site.novini");
    Route::get('/pres_centr/anonsi', 'SiteController@anonsi')->name("site.anonsi");
    Route::get('/pres_centr/photo_galerea', 'SiteController@photo_galerea')->name("site.photo_galerea");
    Route::get('/pres_centr/video_galerea', 'SiteController@video_galerea')->name("site.video_galerea");



    //Dialnist
    Route::get('/dialnist/remont_dorig/vikonani_zahodi', 'SiteController@vikonani_zahodi')->name("site.vikonani_zahodi");
 /*   Route::get('/dialnist/remont_dorig/dorozni_roboti', 'SiteController@dorozni_roboti')->name("site.dorozni_roboti");
    Route::get('/dialnist/remont_dorig/likvidacia_amkovosti', 'SiteController@likvidacia_amkovosti')->name("site.likvidacia_amkovosti");
   */
    Route::get('/dialnist/remont_dorig/zaplanovani_roboti', 'SiteController@zaplanovani_roboti')->name("site.zaplanovani_roboti");
    Route::get('/dialnist/sfera', 'SiteController@sfera')->name("site.sfera");
    Route::get('/dialnist/finansovo-economichna_dialnist', 'SiteController@finansovo_economichna_dialnist')->name("site.finansovo_economichna_dialnist");
    Route::get('/dialnist/derzavni_zakupivli', 'SiteController@derzavni_zakupivli')->name("site.derzavni_zakupivli");


    //Normativna_baza
    Route::get('normativna_baza/ogoloshena', 'SiteController@ogoloshena')->name("site.ogoloshena");
    Route::get('/normativna_baza/rozporadjena', 'SiteController@rozporadjena')->name("site.rozporadjena");

    //Block_news
    Route::get('/admin_panel/blocknews', ['middleware' => 'auth', 'uses' => 'BlocknewsController@index'])->name("admin_panel.blocknews.index");
    Route::post('/admin_panel/blocknews/add', ['middleware' => 'auth', 'uses' => 'BlocknewsController@add'])->name("admin_panel.blocknews.add");
    Route::post('/admin_panel/blocknews/edit',['middleware' => 'auth', 'uses' =>  'BlocknewsController@edit'])->name("admin_panel.blocknews.edit");
    Route::delete('/admin_panel/blocknews/delete/{id}', ['middleware' => 'auth', 'uses' => 'BlocknewsController@delete'])->name("admin_panel.blocknews.delete");
    Route::post('/admin_panel/blocknews', ['middleware' => 'auth', 'uses' => 'BlocknewsController@search'])->name("admin_panel.blocknews.search");


    //StanDorig
    Route::get('/admin_panel/stan_dorig/catalog', ['middleware' => 'auth', 'uses' => 'StanDorigController@index'])->name("admin_panel.stan_dorig.catalog");
    Route::post('/admin_panel/stan_dorig/store', ['middleware' => 'auth', 'uses' => 'StanDorigController@store'])->name("admin_panel.stan_dorig.store");
    Route::delete('/admin_panel/stan_dorig/delete/{id}',['middleware' => 'auth', 'uses' =>  'StanDorigController@destroy'])->name("admin_panel.stan_dorig.delete");
   /*  Route::get('stan_dorig/show/{id}', [ 'uses' => 'StanDorigController@show'])->name("stan_dorig.show");*/
    Route::get('/admin_panel/stan_dorig/create', ['middleware' => 'auth', 'uses' => 'StanDorigController@create'])->name("admin_panel.stan_dorig.create");
    Route::get('/admin_panel/stan_dorig/edit/{id}', ['middleware' => 'auth', 'uses' => 'StanDorigController@edit'])->name("admin_panel.stan_dorig.edit");
    Route::post('/admin_panel/stan_dorig/catalog', ['middleware' => 'auth', 'uses' => 'StanDorigController@search'])->name("admin_panel.stan_dorig.catalog.search");


    //RegionRoad
    Route::get('/admin_panel/roads/catalog', ['middleware' => 'auth', 'uses' => 'RoadsController@index'])->name("admin_panel.roads.catalog");
    Route::post('/admin_panel/roads/store', ['middleware' => 'auth', 'uses' => 'RoadsController@store'])->name("admin_panel.roads.store");
    Route::delete('/admin_panel/roads/delete/{id}',['middleware' => 'auth', 'uses' =>  'RoadsController@destroy'])->name("admin_panel.roads.delete");
    Route::get('roads/show/{type}/{region}', [ 'uses' => 'SiteController@road'])->name("roads.show");
    Route::get('roads/show/{id}', [ 'middleware' => 'auth', 'uses' => 'RoadsController@show'])->name("admin_panel.roads.show");
    Route::get('/admin_panel/roads/create', ['middleware' => 'auth', 'uses' => 'RoadsController@create'])->name("admin_panel.roads.create");
    Route::get('/admin_panel/roads/edit/{id}', ['middleware' => 'auth', 'uses' => 'RoadsController@edit'])->name("admin_panel.roads.edit");
    Route::post('/admin_panel/roads/catalog', ['middleware' => 'auth', 'uses' => 'RoadsController@search'])->name("admin_panel.roads.catalog.search");





