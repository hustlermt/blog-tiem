<?php
include('auth_check.php');  // Ensure only authenticated users can access this page

// Database connection (You mentioned it's in 'queries/connect.php')
include 'queries/connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Post | Administrator Dashboard</title>

    <link href="../img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">


    <style>
        .dz-preview:hover .dz-details {
            display: none;
        }
    </style>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php' ?>
        <?php include 'includes/sidebar.php' ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <div class="container">
                <div class=" row">
                    <div class="col-md-8 offset-md-2">
                        <div id="message-area"></div>
                        <form method="POST" enctype="multipart/form-data" id="addPostForm">
                            <div class="card">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="image_name">Select Cover Image</label>
                                        <input type="file" name="image_name" class="form-control" id="image_name">
                                    </div>

                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <select class="form-control" name="category_id" id="category">
                                            <?php
                                            // Fetch categories from the database
                                            $query = "SELECT id, category FROM categories";
                                            $result = $conn->query($query);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['category'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No categories found</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="headline">Headline</label>
                                        <input type="text" class="form-control" name="headline" id="headline" placeholder="Enter Headline" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="blog_content">Content</label>
                                        <textarea name="blog_content" id="blog_content" class="form-control" cols="30" rows="5" required></textarea>
                                    </div>

                                    <button class="btn btn-primary btn-block" type="submit" id="addPostButton">Add
                                        Post</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'includes/footer.php' ?>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>

    <script src="../js/addpost.js"></script>


</body>

</html>