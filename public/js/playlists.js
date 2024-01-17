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