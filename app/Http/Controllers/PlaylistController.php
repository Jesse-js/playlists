<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Playlist;
use Illuminate\Support\Facades\Log;

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

    public function contents(int $id)
    {
        try {
            if (isset($id)) {
                $playlist = Playlist::findOrFail($id);
                if ($playlist->contents()->exists()) {
                    $contents = $playlist->contents;
                    return response()->json($contents);
                }
                return response()->json([]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
