$(document).ready(function() {
    $('#passwordResetForm').submit(function(event) {
        event.preventDefault();
        var email = $('#resetEmail').val();

        $.ajax({
            url: 'reset_password_request.php',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    });
});
