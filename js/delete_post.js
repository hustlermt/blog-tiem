$(document).ready(function() {
    // Handle click on "Delete" button
    $(document).on('click', '.delete-post-btn', function() {
        var postId = $(this).data('post-id');
        $('#deletePostId').val(postId); 
        $('#deletePostModal').modal('show');
    });

    // Handle click on "Confirm Delete" button
    $('#confirmDeleteButton').click(function() {
        var postId = $('#deletePostId').val();
        
        $.ajax({
            url: "queries/delete_post.php",
            type: 'POST',
            data: { postId: postId },
            dataType: 'json', // Expect a JSON response
            success: function(response) {
                if (response.status === 'success') {
                    // Remove the deleted row from the table
                    $(`[data-post-id="${postId}"]`).closest('tr').remove();
                    $('#deletePostModal').modal('hide');
                    toastr.success(response.message, 'Success!');
                } else {
                    // Display error message (e.g., using an alert or toastr)
                    toastr.error(response.message, 'Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error deleting post:", error); // Log the error for debugging
                // Display error alert for AJAX failure
                toastr.error('An error occurred. Please try again later.', 'Error!');
            }
        });
    });
});

