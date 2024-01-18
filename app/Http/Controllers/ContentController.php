<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            try {
                return datatables()->of(Content::addSelect([
                    'playlist' => Playlist::select('title')
                        ->whereColumn('playlists.id', 'contents.playlist_id')
                ]))
                    ->addColumn('action', 'components.actions')
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
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
