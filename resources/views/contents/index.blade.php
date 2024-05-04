@extends('layouts.app-layout')

@section('title', 'Playlists - Contents')

@section('content')
    <x-header title="Contents" />
    <div class="card-body">
        <table class="table table-striped table-bordered table-responsive-sm" id="contentTable">
            <thead>
                <th>Id</th>
                <th>Playlist</th>
                <th>Title</th>
                <th>Url</th>
                <th>Author</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </thead>
        </table>
    </div>
    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentModalTitle">Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="contentForm" name="contentForm" class="form-horizontal"
                        method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Playlist</label>
                            <div class="col-sm-12">
                                <select name="playlistId" id="playlistId" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Enter Content Title" minlength="3" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="author" name="author"
                                    placeholder="Enter Author Name" minlength="3" maxlength="150">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">Url</label>
                            <div class="col-sm-12">
                                <input type="url" class="form-control" name="url" id="url" minlength="10"
                                    maxlength="255" placeholder="https://example.com" pattern="http://.*|https://.*" required>
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
    <x-delete-confirm context="content" />
    @push('scripts')
        <script src="{{ asset('js/contents.js') }}"></script>
    @endpush
@endsection
