<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertPlaylistRequest;
use App\Models\Playlist;
use Illuminate\Support\Facades\Log;
use Exception;

class PlaylistController extends Controller
{

    public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(Playlist::select('*'))
                    ->addColumn('action', 'components.actions')
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return view('playlists.index');
    }

    public function upsert(UpsertPlaylistRequest $request)
    {
        try {
            $playlist = Playlist::updateOrCreate(
                ['id' => $request->id],
                [
                    'title' => $request->title,
                    'description' => $request->description,
                    'author' => $request->author
                ]
            );

            return response()->json($playlist);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Internal server error, please try again later!",
            ], 500);
        }
    }

    public function edit(int $id)
    {
        try {
            $playlist = Playlist::findOrFail($id);
            return response()->json($playlist);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Internal server error, please try again later!",
            ], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $playlist = Playlist::findOrFail($id);
            $playlist->delete();
            return response()->json($playlist);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Internal server error, please try again later!",
            ], 500);
        }
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
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Internal server error, please try again later!",
            ], 500);
        }
    }
}
