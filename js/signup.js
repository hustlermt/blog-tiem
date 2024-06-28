$(document).ready(function() {
    $("#signupForm").submit(function(event) {
        event.preventDefault();

        // Get form data
        var formData = $(this).serialize();

        $.ajax({
            url: 'queries/process_signup.php',
            type: 'POST',
            data: formData,
            dataType: 'json', // Ensure that the expected response is JSON
            success: function(response) {
                if (response.status === 'success') {
                    // Login successful, redirect to dashboard
                    $("#message-area").html('<div class="alert alert-success alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    // Redirect after 1.5 seconds
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 1500); // 1500 milliseconds 
                    $("#signupForm")[0].reset();
                } else {
                    // Display error alert
                    $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                // Display error alert for AJAX failure
                $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while processing your request.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        });
    });
});
