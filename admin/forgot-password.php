<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiem Civil Engineers | Forgot Password</title>
    <link href="../img/favicon.ico" rel="icon" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="../css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <link rel="stylesheet" href="dist/css/adminlte.min.css?v=3.2.0">
</head>

<body >
    <?php include '../partials/navbar-admin.php' ?>
    
    <div class="hold-transition login-page">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <h4 class="login-box-msg">PASSWORD RESET</h4>
                <form id="passwordResetForm" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" id="resetEmail" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Request Password Reset</button>
                        </div>
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="login.php">Login</a>
                </p>
                <p class="mb-0">
                    <a href="signup.php" class="text-center">Register Account</a>
                </p>
            </div>
        </div>
    </div>
</div>


    <script>
    $(document).ready(function() {
        $('#passwordResetForm').submit(function(event) {
            event.preventDefault();
            var email = $('#resetEmail').val();

            $.ajax({
                url: 'queries/reset_password_request.php',
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });
    });
    </script>

    <script src="plugins/jquery/jquery.min.js"></script>

    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="dist/js/adminlte.min.js?v=3.2.0"></script>
    <script src="../js/password_reset.js"></script>
</body>

</html>