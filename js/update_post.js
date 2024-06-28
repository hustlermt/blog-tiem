$(document).ready(function() {
    $('#blog_content').summernote({
        placeholder: 'Write your blog content here...',
        tabsize: 2,
        height: 180,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']]
        ]
    });

    $("#postImage").change(function() {
        const imageFile = this.files[0];
        if (imageFile) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(imageFile);
        } else {
            $('#imagePreview').attr('src', '');
            $('#imagePreview').hide();
        }
    });

    $('#editPostForm').submit(function(event) {
        event.preventDefault();
        let data = new FormData(this);

        // Log the FormData contents
        for (let pair of data.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: "queries/update_post_query.php",
            type: 'POST',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    $("#message-area").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Error: ' + error + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        });
    });
});
