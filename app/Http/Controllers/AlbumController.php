<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Filesystem\Filesystem;


class AlbumController extends Controller
{
    public static function checkAlbumOwner(Request $request, $id)
    {
        if ($request->session()->has('albums'))
            $albums_list = unserialize($request->session()->get('albums'));
        else
            return false;
        if (array_search($id, $albums_list) === false)
            return false;
        return true;
    }

    public function getAllAlbums(Request $request)
    {
        $albums = Album::where('user_id', Auth::id())->get();
        $albums_list = array();
        foreach ($albums as $album) {
            $albums_list[] += $album['id'];
        }
        $request->session()->put('albums', serialize($albums_list));
        return view('albums', compact('albums'));
    }


    public function deleteAlbum($id, Request $request)
    {
        if (!AlbumController::checkAlbumOwner($request, $id))
            return redirect('/');
        DB::table('albums')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
        $images_path = 'storage/images/'.Auth::id().'/'.$id;
        if (file_exists($images_path))
        {
            (new Filesystem())->cleanDirectory($images_path);
            rmdir($images_path);
        }
        return redirect('/');
    }

    public function albumEditor(Request $request, $id)
    {
        if (!AlbumController::checkAlbumOwner($request, $id))
            return redirect('/');
        $album = Album::where('id', $request->id)->get()->first();
        return view('album-editor', compact('album'));
    }

    public function editAlbum(Request $request)
    {
         $request->validate([
            'name' => 'required|max:30',
        ]);
        if (!AlbumController::checkAlbumOwner($request, $request->id))
            return redirect('/');
        Album::where('id', $request->id)
          ->update(['name' => $request->name]);
        return redirect()->route('albums.index');
    }

    public function getAlbum(Request $request, $id)
    {
        $album_id = $id;
        if (!AlbumController::checkAlbumOwner($request, $id))
            return redirect('/');
        $photos = DB::table('albums')
            ->select('images.id as id', 'images.name as name', 'path', 'path_resize',
                'albums.name as album', 'albums.id as album_id')
            ->join('images', 'images.album_id', '=', 'albums.id')
            ->where('images.user_id', Auth::id())
            ->where('album_id', $id)
            ->get();

        return view('album', compact('photos', 'album_id'));
    }

    public function addAlbum(Request $request)
    {
        $request->validate([
            'name' => 'required|max:30',
        ]);
        $album = new Album;
        $album->name = $request->name;
        $album->user_id = Auth::id();
        $album->save();
        return redirect()->route('albums.index');
    }

}
