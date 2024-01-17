
$(document).ready(function () {
    $('#playlistTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/playlists',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'author', name: 'author'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[0, 'asc']],
    });
})

function add() {
    $('#playlistModal').modal('show');
}

$('#playlistForm').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    if(!formData.get('id')){
        $.ajax({
            type: 'POST',
            url: '/playlists',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#playlistModal').modal('hide');
                //$('#playlistTable').DataTable().ajax.reload();
            },
            error: function (data) {
                console.log(data);
            }
        });
    } else {
        console.log(formData.get('id'));
    }
});