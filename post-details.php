<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Tiem Civil and Structural Engineers</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="civil engineering, structural engineering, architectural engineering, project management, site inspection, electrical engineering, construction, land development, infrastructure, Zimbabwe, SADC, COMESA, engineering services, building design, construction management, project planning, land development consulting, urban development"
        name="keywords">
    <meta
        content="TIEM Civil & Structural Engineers: Your trusted partner for comprehensive engineering solutions in Zimbabwe and beyond. We specialize in architectural, civil, and structural engineering, project management, construction, and land development, offering a one-stop shop for all your project needs. "
        name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Oswald:wght@200;300;400&display=swap"
        rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .blog-img {
            width: 750px;
            /* Set fixed width */
            height: 400px;
            /* Set fixed height */
            overflow: hidden;
            /* Hide overflowing parts of the image */
        }

        .blog-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Or use object-fit: contain to keep aspect ratio */
        }
    </style>
</head>

<body class="page">

    <?php include 'partials/navbar.php' ?>


    <!-- Single Page Start -->
    <?php
    include ('admin/queries/connect.php');

    // 1. Get Post ID and Slug
    if (isset($_GET['id']) && isset($_GET['slug'])) {
        $postId = mysqli_real_escape_string($conn, $_GET['id']);
        $slug = mysqli_real_escape_string($conn, $_GET['slug']);

        // 2. Fetch Post Data
        $query = "SELECT * FROM blog WHERE id = ? AND slug = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $postId, $slug); // 'i' for integer id, 's' for string slug
        $stmt->execute();
        $result = $stmt->get_result();

        // 3. Check if Post Exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $date = new DateTime($row['post_date']);
            $formattedDate = $date->format('d-M-Y');

            // 4. Display Post Details
            echo '<div class="single mt-125">';
            echo '<div class="container">';
            echo '<div class="section-header">';
            echo "<h2><i class='fa fa-calendar-alt'></i> <span>{$formattedDate}</span></h2>"; // Display headline
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-12">';
            echo "<img src='img/blog/{$row['image_name']}' alt='{$row['headline']}' class='img-fluid blog-img' height='400px'>";
            echo '<div class="mt-50"></div>';
            echo "<h2 class='text-uppercase mt-5 text-center'>{$row['headline']}</h2>"; // Display headline
            echo "<p class='blog-content mt-5'>{$row['blog_content']}</p>";
            echo '<div class="blog-meta">';
            // echo "<i class='fa fa-calendar-alt'></i> <span>{$formattedDate}</span>";
    
            echo "</div>"; // blog meta
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            // 5. Handle if Post Not Found
            echo '<div class="container alert-post">
                <div class="alert alert-warning text-center text-dark" role="alert">
                    Post not found.
                </div>
              </div>';
        }
    } else {
        // 6. Handle Missing ID or Slug
        echo ' <div class="mt-150"></div>
        <div class="container ">
            <div class="alert alert-danger " role="alert">
                Invalid post request.
            </div>
          </div>';
    }

    // 7. Close Database Connection
    $conn->close();
    ?>

    <!-- Single Page End -->


    <div class="footer">
        <div class="container copyright">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <a href="#">Tiem Civil & Structural Engineers</a></p>
                </div>
                <div class="col-md-6">
                    <p>Designed By <a href="https://codewand.co.zw">Codewand</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>