<?php

namespace App\Http\Controllers;

use App\Files;
use App;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;


class FilesController extends Controller
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
                // $pt_big = public_path('storage/uploads/files/pages/' . $filename);
                //$file->save($pt_big);
                $path = public_path().'/storage/uploads/files/'. $date_directory . '/' ;
                File::makeDirectory($path, $mode = 0777, true, true);
                $image->move(public_path('storage/uploads/files/'. $date_directory. '/'), $filename);
                $fileUpload = new Files();
                $fileUpload->title = $avatarName;
                $fileUpload->path = $filename;
                $fileUpload->save();
                $id_file = $fileUpload->id;

                return response()->json(['success' => $avatarName, 'id_file' => $id_file]);
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
                $file = App\Files::where('title', $filename)->latest()->first();
                // $file_pg_ar = App\FilesPgAr::where('id_files', $file->id);
                $id_file = $file->id;
                $path = public_path() . '/storage/uploads/files/' . date_create($file->created_at)->Format('Y_m') . '/' . $file->path;
                $file->delete();
                //   $file_pg_ar->delete();
                if (file_exists($path)) {
                    unlink($path);
                }
                return $id_file;
            }

            if (isset($request->id)) {
                if ($request->ajax()) {
                    $id = $request->id;
                    $file = App\Files::find($id);
                    $file_pg_ar = App\FilesPgAr::where('id_files', $id)->first();
                    $file_pg_ar->delete();
                    $path = public_path() . '/storage/uploads/files/' . date_create($file->created_at)->Format('Y_m')  . '/' . $file->path;
                    $file->delete();
                    //   $file_pg_ar->delete();
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    return $id;
                }

            } else {
                return response()->json(['fail' => "Ошибка"]);
            }
        }
        catch (\Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
    }

}
