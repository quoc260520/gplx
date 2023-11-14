function readURL(input, idInputPreview) {
    if (input.target.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#' + idInputPreview).attr('src', e.target.result);
        }

        reader.readAsDataURL(input.target.files[0]);
    }
}

$("#image_staff").change(function (event) {
    readURL(event, 'avatar_pre');
});
function confirmation(event) {
    event.preventDefault();
    url = event.currentTarget.getAttribute('href');
    swal({
        title: "Bạn chắc chắn muốn xóa",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
        .then((willCancel) => {
            if (willCancel) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) { },
                    error: function (error) { },
                    complete: function () {
                        location.reload();
                    },
                })
            }
        });
}
