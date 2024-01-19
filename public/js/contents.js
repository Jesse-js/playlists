$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("#_token").val(),
        },
    });
    $("#contentTable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "/contents",
        },
        columns: [
            { data: "id", name: "id" },
            { data: "playlist", name: "playlist", searchable: false },
            { data: "title", name: "title" },
            { data: "url", name: "url" },
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
    $("#contentForm").trigger("reset");
    $("#contentModalTitle").text("Add Content");
    $("#playlistId").prop("selectedIndex", 0);
    getPlaylists();
    $("#contentModal").modal("show");
    $("#id").val("");
}

function edit(id) {
    $.ajax({
        type: "GET",
        url: `/contents/${id}/edit`,
        data: {
            id: id,
        },
        dataType: "json",
        success: function (data) {
            $("#contentModalTitle").text("Edit Content");
            $("#contentModal").modal("show");
            $("#id").val(data.id);
            getPlaylists(data.playlist_id);
            $("#title").val(data.title);
            $("#url").val(data.url);
            $("#author").val(data.author);
        },
        error: function (data) {
            console.log(data);
        },
    });
}

function getPlaylists(playlistId = null) {
    $("#playlistId").empty();
    $.ajax({
        type: "GET",
        url: "contents/playlist",
        success: function (data) {
            loadOptions(data, playlistId);
        },
        error: function (data) {
            console.log(data);
        },
    });
}

function loadOptions(data, playlistId = null) {
    var playlistSelect = $("#playlistId");
    for (var playlist of data) {
        var playlistOption = $('<option class="dropdown-item">');
        playlistOption.val(playlist.id);
        playlistOption.text(playlist.title);
        if (playlistId == playlist.id) playlistOption.prop("selected", true);

        playlistSelect.append(playlistOption);
    }
}

$("#contentForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        url: "/contents/upsert",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#contentModal").modal("hide");
            $("#contentTable").DataTable().ajax.reload();
        },
        error: function (data) {
            console.log(data);
        },
    });
});


function deleteConfirm(id, title) {
  $("#contentForm").trigger("reset");
  $("#id").val(id);
  $("#contentModalTitle").text("Delete Content");
  $("#contentTitle").html(title);
  $("#deleteModal").modal("show");
}

$("#deleteForm").submit(function (e) {
  e.preventDefault();
  $.ajax({
      type: "DELETE",
      url: `/contents/${$("#id").val()}`,
      data: {
          id: $("#id").val(),
      },
      dataType: "json",
      success: function (data) {
          $("#deleteModal").modal("hide");
          $("#contentTable").DataTable().ajax.reload();
      }
  }) 
});
