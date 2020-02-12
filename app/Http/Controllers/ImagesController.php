<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $date_directory = date("Y_m");
            if (isset($request->file)) {
                $image = $request->file('file');
                $avatarName = $image->getClientOriginalName();
                //   $file = Image::make($image->path());
                $filename = $avatarName . '_' . time() . '.' . $image->getClientOriginalExtension();
                // $pt_big = public_path('storage/uploads/images/pages/' . $filename);
                // $file->save($pt_big);
                $small_img = Image::make($image->path())->orientate();
                $big_image = Image::make($image->path())->orientate();
                $small_img->resize(600, 800, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $big_image->resize(3000, 1600, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $path = public_path().'/storage/uploads/images/'. $date_directory . '/'. 'gallery/'. 'small/' ;
                $path_2 = public_path().'/storage/uploads/images/'. $date_directory . '/'. 'gallery/'. 'big/' ;
                File::makeDirectory($path, $mode = 0777, true, true);
                File::makeDirectory($path_2, $mode = 0777, true, true);
                $pt_small = public_path('storage/uploads/images/'. $date_directory .'/'. 'gallery/'. 'small/' . $filename);
                $pt_big = public_path('storage/uploads/images/' . $date_directory .'/' . 'gallery/'. 'big/' . $filename);

                $small_img->save($pt_small);
                $big_image->save($pt_big);

                //  $image->move(public_path('storage/uploads/files/pages/'), $filename);
                $fileUpload = new App\Images();
                $fileUpload->title = $avatarName;
                $fileUpload->path = $filename;
                $fileUpload->save();
                $id_file = $fileUpload->id;

                return response()->json(['success' => $avatarName, 'id_image' => $id_file]);
            } else {
                return response()->json(['fail' => "Ошибка"]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function show(Files $files)
    {
        //
    }

    public function edit(Files $files)
    {
        //
    }

    public function update(Request $request, Files $files)
    {
        //
    }

    public function destroy(Request $request)
    {
        try {
            if (isset($request->filename)) { // удаление новых файлов
                $filename = $request->filename;
                $file = App\Images::where('title', $filename)->latest()->first();
                // $file_pg_ar = App\FilesPgAr::where('id_files', $file->id);
                $id_file = $file->id;
             //   $path = public_path() . '/storage/uploads/images/' . $file->path;
                $path =  public_path().'/storage/uploads/images/'. date_create($file->created_at)->Format('Y_m') . '/'. 'gallery/'. 'big/' . $file->path;
                $path_2 = public_path().'/storage/uploads/images/'. date_create($file->created_at)->Format('Y_m') . '/'. 'gallery/'. 'small/' . $file->path;
                $file->delete();
                //   $file_pg_ar->delete();
                if (file_exists($path)) {
                    unlink($path);
                }

                if (file_exists($path_2)) {
                    unlink($path_2);
                }


                return $id_file;
            }
            if (isset($request->id)) { // Удаление ранее добавленых изображений
                if ($request->ajax()) {
                    $id = $request->id;
                    $file = App\Images::find($id);
                    $file_pg_ar = App\ImagesPgAr::where('id_images', $id)->first();
                    $file_pg_ar->delete();

                    $path =  public_path().'/storage/uploads/images/'. date_create($file->created_at)->Format('Y_m') . '/'. 'gallery/'. 'big/' . $file->path;
                    $path_2 = public_path().'/storage/uploads/images/'. date_create($file->created_at)->Format('Y_m') . '/'. 'gallery/'. 'small/' . $file->path;
                    $file->delete();
                    //   $file_pg_ar->delete();
                    if (file_exists($path)) {
                        unlink($path);
                    }

                    if (file_exists($path_2)) {
                        unlink($path_2);
                    }
                    return "deleted";
                }

            } else {
             //   return "Ошибка!";
                return response()->json(['fail' => "Ошибка"]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
