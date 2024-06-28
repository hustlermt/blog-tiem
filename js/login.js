$(document).ready(function() {
    $("#loginForm").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: 'queries/process_login.php',
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect a JSON response
            success: function(response) {
                if (response.status === 'success') {
                    // Login successful, redirect to dashboard
                    $("#message-area").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> Login Successful <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

                    // Redirect after 1.5 seconds
                    setTimeout(function() {
                        window.location.href = "posts.php";
                    }, 1500); // 1500 milliseconds 
                    $("#loginForm")[0].reset();
                } else {
                    // Display error message (account not found, wrong password, or inactive)
                    $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText); // Log the error for debugging
                $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred. Please try again later.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        });
    });
});
