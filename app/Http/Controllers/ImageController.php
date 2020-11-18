<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as ImageManager;


class ImageController extends Controller
{
     public function uploadForm($album_id)
    {
        return view('upload', compact('album_id'));
    }

    public function deleteFile(Request $request, $id)
    {
         $image = Image::where('id' , $id)
             ->where('user_id', Auth::id())
             ->get()->first();
         if (!$image)
              return redirect('/');
         DB::table('images')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        if (file_exists($image->path) &&  file_exists($image->path_resize))
        {
            unlink($image->path);
            unlink($image->path_resize);
        }
        return back();
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file'  =>   'required|image',
            'name'  =>   'required|max:20',
            'album_id' =>   'required',
        ]);
        $album_id = $request->album_id;
        try {
            $file =  $request->file('file');
            $file_name = $file->getClientOriginalName();
            $images_path = 'storage/images/'.Auth::id().'/'.$album_id.'/';
            if (!file_exists($images_path) || !is_dir($images_path))
                mkdir($images_path, 0777, true);
            $image = ImageManager::make($file->getRealPath());
            $file_path = $images_path.time().$file_name;
            $file_path_resize = $images_path.'resize_'.time().$file_name;
            $image_public_path = public_path($file_path);
            $image_public_path_resize = public_path($file_path_resize);
            $image->save($image_public_path);
            $image_resize = ImageManager::make($file->getRealPath());
            $width = $image_resize->getWidth();
            $height = $image_resize->getHeight();
            $image_resize->resize($width > $height ? 150 : null, $width <= $height ? 150 : null,
                function ($constraint) {
                $constraint->aspectRatio();
            })->save($image_public_path_resize);
        } catch (Exception $e) {
            return back()->with('error', 'Upload failed!');
        }
        $image = new Image;
        $image->user_id = Auth::id();
        $image->name = $request->name;
        $image->path = $file_path;
        $image->path_resize = $file_path_resize;
        $image->album_id = $album_id;
        $image->save();
        return back()->with('success', 'Upload success!');
    }
}
