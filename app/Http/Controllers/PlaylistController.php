<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;

class PlaylistController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Playlist::select('*'))
                ->addColumn('action', 'components.actions')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('playlists.index');
    }

    public function upsert(Request $request)
    {
        $playlist = Playlist::updateOrCreate(
            ['id' => $request->id],
            [
                'title' => $request->title,
                'description' => $request->description,
                'author' => $request->author
            ]
        );

        return response()->json($playlist);
    }

    public function edit(int $id)
    {
        $playlist = Playlist::findOrFail($id);
        return response()->json($playlist);
    }

    public function destroy(int $id)
    {
        $playlist = Playlist::findOrFail($id);
        $playlist->delete();
        return response()->json($playlist);
    }
}
