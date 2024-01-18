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
            { data: "playlist", name: "playlist" },
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
}

function getPlaylists(id) {
    if (!id) {
        $.ajax({
            type: "GET",
            url: "contents/playlist",
            success: function (data) {
                loadOptions(data);
            },
            error: function (data) {
                console.log(data);
            },
        });
    }
}

function loadOptions(data) {
    var playlistSelect = $("#playlistId");
    for (var playlist of data) {
        var playlistOption = $('<option class="dropdown-item">');
        playlistOption.val(playlist.id);
        playlistOption.text(playlist.title);
        playlistOption.prop("selected", playlist.selected);

        playlistSelect.append(playlistOption);
    }
}

// $("#contentModal").on("show.bs.modal", function () {
//     var playlistSelect = $("#playlistId");

//     var playlists = [
//         { value: "1", text: "Opção 1", selected: true },
//         { value: "2", text: "Opção 2" },
//         { value: "3", text: "Opção 3" },
//     ];

//     for (var playlist of playlists) {
//         var playlistOption = $("<option>");

//         playlistOption.val(playlist.value);
//         playlistOption.text(playlist.text);
//         playlistOption.prop("selected", playlist.selected);

//         playlistSelect.append(playlistOption);
//     }
// });

// function carregarOpcoes() {
//     var selectElement = $("#seuSelect");

//     $.ajax({
//       url: "/teste",
//       method: "GET",
//       dataType: "json",
//       success: function(response) {
//         // Loop através do JSON recebido
//         for (var option of response) {
//           // Crie um objeto de opção
//           var optionElement = $("<option>");

//           // Defina o valor e o texto da opção
//           optionElement.val(option.value);
//           optionElement.text(option.text);

//           // Adicione a opção ao elemento select
//           selectElement.append(optionElement);
//         }
//       },
//       error: function(xhr, status, error) {
//         console.log("Erro ao carregar opções:", error);
//       }
//     });
//   }

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
