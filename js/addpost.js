$(document).ready(function() {
    $('#blog_content').summernote({
        placeholder: 'Write your blog content here...',
        tabsize: 2,
        height: 150, // Adjust height as needed
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']] 
        ]
      });
   
     // Image preview
     $("#image_name").change(function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    $("#addPostForm").submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        if ($('#image_name').get(0).files.length === 0) {
            $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Please select an image to upload.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            return;
        }

        $.ajax({
            url: "queries/add_post_query.php",
            type: 'POST',
            data: formData,
            contentType: false, //Important
            cache: false,
            processData: false,
            dataType: 'json', // Expect a JSON response
            success: function(response) {
                if (response.status === 'success') {
                    // Success alert
                    $("#message-area").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                    // Clear form fields and image preview
                    $("#addPostForm")[0].reset();
                    $('#imagePreview').attr('src', '');
                    $('#imagePreview').hide();
                } else {
                    // Error alert
                    $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error); // Log the error for debugging
                // Display error alert for AJAX failure
                $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred. Please try again later.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        });
    });
});
