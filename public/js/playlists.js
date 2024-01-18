$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("#_token").val(),
        },
    });
    $("#playlistTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/playlists",
        },
        columns: [
            { data: "id", name: "id" },
            { data: "title", name: "title" },
            { data: "description", name: "description" },
            { data: "author", name: "author" },
            { data: "created_at", name: "created_at" },
            { data: "updated_at", name: "updated_at" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
        order: [[0, "desc"]],
    });
});

function add() {
    $("#playlistForm").trigger("reset");
    $("#playlistModalTitle").text("Add Playlist");
    $("#playlistModal").modal("show");
    $("#id").val("");
}

function edit(id) {
    $.ajax({
        type: "GET",
        url: `/playlists/${id}/edit`,
        data: {
            id: id,
        },
        dataType: "json",
        success: function (data) {
            $("#playlistModalTitle").text("Edit Playlist");
            $("#playlistModal").modal("show");
            $("#id").val(data.id);
            $("#title").val(data.title);
            $("#description").val(data.description);
            $("#author").val(data.author);
        },
        error: function (data) {
            console.log(data);
        },
    });
}

$("#playlistForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "/playlists/upsert",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#playlistModal").modal("hide");
            $("#playlistTable").DataTable().ajax.reload();
        },
        error: function (data) {
            console.log(data);
        },
    });
});

function deleteConfirm(id, title) {
    $("#playlistForm").trigger("reset");
    $("#id").val(id);
    $("#playlistModalTitle").text("Delete Playlist");
    $("#playlistTitle").html(title);
    $("#deleteModal").modal("show");
}

$("#deleteForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "DELETE",
        url: `/playlists/${$("#id").val()}`,
        data: {
            id: $("#id").val(),
        },
        dataType: "json",
        success: function (data) {
            $("#deleteModal").modal("hide");
            $("#playlistTable").DataTable().ajax.reload();
        }
    }) 
});
