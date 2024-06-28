<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../img/favicon.ico" rel="icon" />


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="../img/logo.png" alt="Tiem Logo" class="img-fluid"> 
                    </div>
                    <div class="card-title mt-3">
                        <h2 class="text-center">LOGIN</h2>
                    </div>
                    <div class="card-body">
                        <form id="loginForm" method="POST"> 
                            <div id="message-area"></div>

                            <div class="form-group">
                               <label for="userName">Username</label>
                               <input type="text" class="form-control" id="username" name="username">
                            </div>
                           
                            <div class="form-group">
                               <label for="password">Password</label>
                               <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-success btn-block" id="loginBtn">Sign In</button>
                            </div>                                                      
                           
                        </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/login.js"></script>
 
</body>

</html>
