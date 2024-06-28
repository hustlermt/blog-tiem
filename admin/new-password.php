<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tiem Civil Engineers | New Password</title>
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
                <h4 class="login-box-msg">Create New Password</h4>
                <form id="newpass" method="POST">
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                    <div id="message-area"></div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="New Password" id="password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text btn btn-success" id="togglePassword">
                                <span class="fas fa-eye"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" id="saveNewPassword">Save New Password</button>
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
            $('#newpass').submit(function(event) {
                event.preventDefault();
                var token = $('input[name="token"]').val();
                var password = $('#password').val();

                $.ajax({
                    url: 'update_password.php',
                    type: 'POST',
                    data: { token: token, password: password },
                    dataType: 'json',
                    success: function(response) {
                        alert(response.message);
                        if (response.status === 'success') {
                            window.location.href = 'login.php';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });

            $('#togglePassword').click(function() {
                const passwordInput = $('#password');
                const passwordIcon = $(this).find('.fas');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>

    <script src="plugins/jquery/jquery.min.js"></script>

    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="dist/js/adminlte.min.js?v=3.2.0"></script>
    <script src="../js/login.js"></script>
</body>

</html>