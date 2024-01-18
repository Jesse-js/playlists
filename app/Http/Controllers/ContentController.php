<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Playlist;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        return view('contents.index');
    }

    public function upsert(Request $request)
    {
        $content = Content::updateOrCreate(
            ['id' => $request->id],
            [
                'playlist_id' => $request->playlistId,
                'title' => $request->title,
                'url' => $request->url,
                'author' => $request->author
            ]
        );

        return response()->json($content);
    }

    public function edit(int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }

    public function playlist(int $id = null)
    {
        if (isset($id)) {
            $content = Content::findOrFail($id);
            $playlist = $content->playlist;
            return response()->json($playlist);
        }
        $playlist = Playlist::all();
        return response()->json($playlist);
    }
}
