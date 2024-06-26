@extends('layouts.app-layout')

@section('title', 'Playlists - Playlists')

@section('content')
    <x-header title="Playlists" />
    <div class="card-body">
        <table class="table table-striped table-bordered table-responsive-sm" id="playlistTable">
            <thead>
                <th>Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="playlistModal" tabindex="-1" aria-labelledby="playlistModalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="playlistModalTitle">Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="playlistForm" name="playlistForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter Playlist Title" minlength="3" maxlength="100" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="author" name="author"
                                    placeholder="Enter Author Name" minlength="3" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5" maxlength="200"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10 mt-2">
                            <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save
                                changes</button>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <x-delete-confirm context="playlist">
        <p id="playlistContentDeleteMessage"></p>
        <ul id="playlistContentDeleteList" class="list-group">

        </ul>
    </x-delete-confirm>


    @push('scripts')
        <script src="{{ asset('js/playlists.js') }}"></script>
    @endpush
@endsection
