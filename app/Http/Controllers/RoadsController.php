<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkjurnalist', ['except' => ['show']]);
    }

    public function index()
    {
        try {
            $data = App\Roads::orderBy('id', 'desc')->paginate(10);
            $types = App\TypeRoads::all();
            $regions = App\Regions::all();

            return view("admin_panel/roads/catalog", ["data" => $data,
                'regions' => $regions,
                'types' => $types, 'regions' => $regions
            ]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function create()
    {
       try {
           $type = App\TypeRoads::all();
           $region = App\Regions::all();
           return view("admin_panel/roads/create", ['type' => $type, 'region' => $region]);
       }
       catch (\Exception $e){
           return back()->withError($e->getMessage())->withInput();
       }
    }

    public function edit($id)
    {
        try {
            if (isset($id)) {
                $data = App\Roads::find($id);
                $type = App\TypeRoads::all();
                $region = App\Regions::all();
                return view("admin_panel/roads/create", ['data' => $data, 'type' => $type, 'region' => $region]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }

    }


    public function show($id)
    {
        try {
            $data = App\Roads::find($id);

            $articles_more = App\Articles::where('status', '=', true)

                ->where(function ($q) {
                    $q->where('date_advice', null)->OrWhereDate('date_advice', '<=', date("y-m-d"));
                })
                ->where(function ($q) {
                    $q->where('date_advice_end', null)->orWhereDate('date_advice_end', '>', date("y-m-d"));
                })
                ->orderBy('id', 'desc')->take(10)->get();
            return view('public/roads/show', ['data' => $data,  'articles_more' => $articles_more]);
        }
        catch (\Exception $e){
            return back();
        }
    }


    public function search(Request $request){
        try {
            $type_search = $request->type_search;
            $type_search_region = $request->type_search_region;
            if ($type_search != 'Все' && $type_search_region != 'Все') {
                $data = App\Roads::whereHas('type_roads', function ($query) use ($type_search) {
                    $query->where('name', $type_search);
                })->whereHas('regions', function ($query) use ($type_search_region) {
                    $query->where('name', $type_search_region);
                })->orderBy('id', 'desc')->paginate(10);
            } else if ($type_search != 'Все') { //Все
                $data = App\Roads::whereHas('type_roads', function ($query) use ($type_search) {
                    $query->where('name', $type_search);
                })->orderBy('id', 'desc')->paginate(10);
            } else if ($type_search_region != 'Все') {
                $data = App\Roads::whereHas('regions', function ($query) use ($type_search_region) {
                    $query->where('name', $type_search_region);
                })->orderBy('id', 'desc')->paginate(10);
            }
            //   $data = App\Articles::where('status', '=', true)->orderBy('id', 'desc')->paginate(10);
            $types = App\TypeRoads::all();
            $regions = App\Regions::all();
            return view("admin_panel/roads/catalog", ["data" => $data,
                'type_search' => $type_search,
                'type_search_region' => $type_search_region,
                'types' => $types, 'regions' => $regions
            ]);
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function store(Request $request)
    {
       try {
           if (isset($request)) {
                  $this->validate($request, [
                      'title' => 'max:191',
                  ]);

               if (!isset($request->edit)) { //добавление страницы
                   $data = new App\Roads();
                   $data->title = strip_tags(html_entity_decode($request->title));
                   $data->body = $request->body;
                   $data->id_type = $request->id_type;
                   $data->id_region = $request->id_region;
                   $data->meta_description = $request->meta_description;
                   $data->meta_keywords = $request->meta_keywords;
                   $data->id_user = Auth::user()->id;
                   $data->save();
                   Session::flash('success', 'Додано успішно');
                   return redirect()->route('admin_panel.roads.create')->with('message', 'Запис додан');
               }
               else { //Редактирование страницы

                   $data = App\Roads::find($request->id);
                   $data->title = strip_tags(html_entity_decode($request->title));
                   $data->body = $request->body;
                   $data->id_type = $request->id_type;
                   $data->id_region = $request->id_region;
                   $data->meta_description = $request->meta_description;
                   $data->meta_keywords = $request->meta_keywords;
                   $data->id_user = Auth::user()->id;
                   $data->save();
                   Session::flash('success', 'Змінено успішно');
                   return redirect()->route('admin_panel.roads.catalog')->with('message', 'Запис оновлен');
               }
           }
       }
       catch (\Exception $e){
           return back()->withError($e->getMessage())->withInput();
       }
    }

}
