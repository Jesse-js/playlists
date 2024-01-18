<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertContentRequest;
use App\Models\Content;
use App\Models\Playlist;
use Exception;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function index()
    {
        try {
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
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return view('contents.index');
    }

    public function upsert(UpsertContentRequest $request)
    {
        try {
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
            $content = Content::findOrFail($id);
            return response()->json($content);
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
            $content = Content::findOrFail($id);
            $content->delete();
            return response()->json($content);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Internal server error, please try again later!",
            ], 500);
        }
    }

    public function playlist(int $id = null)
    {
        try {
            if (isset($id)) {
                $content = Content::findOrFail($id);
                $playlist = $content->playlist;
                return response()->json($playlist);
            }
            $playlist = Playlist::all();
            return response()->json($playlist);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Internal server error, please try again later!",
            ], 500);
        }
    }
}
