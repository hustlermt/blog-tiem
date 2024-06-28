<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TIEM Civil and Structural Engineers | BLIG | ENGINEERING ARTICLES</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="civil engineering, structural engineering, architectural engineering, project management, site inspection, electrical engineering, construction, land development, infrastructure, Zimbabwe, SADC, COMESA, engineering services, building design, construction management, project planning, land development consulting, urban development"
        name="keywords">
    <meta content="TIEM Civil & Structural Engineers: Your trusted partner for comprehensive engineering solutions in Zimbabwe and beyond. We specialize in architectural, civil, and structural engineering, project management, construction, and land development, offering a one-stop shop for all your project needs. "
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
      .truncate-3-sentences {
      display: block; /* or inline-block */
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap; /* Prevent line breaks */
    }
    .blog-img {
        overflow: hidden; /* Hide overflowing parts of the image */
    }

    .blog-img img {
        width: 100%; /* Make the image take up the full width of the container */
        height: 350px; /* Set a fixed height */
        object-fit: cover; /* Cover the container while maintaining aspect ratio */
    }

    </style>

</head>

<body class="page">


    <?php include 'partials/navbar.php' ?>
    
    <!-- content here -->
    <div class="blog blog-page mt-125">
      <div class="container">
        <div class="section-header">
          
          <h2>Recent Blog Articles</h2>
        </div>
        <div class="row">
          
        <?php
        // 1. Include database connection
        include('admin/queries/connect.php');  

        // 2. Check for connection error
        if (isset($connectionError) && $connectionError) {
            echo "<div class='alert alert-danger' role='alert'>$error_message</div>"; // from connect.php
            exit;
        }

        // 3. Fetch all posts, including category name
        $query = "SELECT b.id, b.headline, b.post_date, b.image_name, c.category, b.blog_content, b.slug
                  FROM blog b
                  LEFT JOIN categories c ON b.category_id = c.id
                  ORDER BY b.post_date DESC"; 

        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $date = new DateTime($row['post_date']);
                $formattedDate = $date->format('d-M-Y');

                // Truncate blog content for summary
                $blogSummary = mb_strimwidth(strip_tags($row['blog_content']), 0, 50, "...");

                echo '<div class="col-md-6">';
                echo '<div class="blog-item">';
                echo "<div class='blog-img'>";
                echo "<img src='img/blog/{$row['image_name']}' alt='{$row['headline']}' />"; // Assuming 'img/blog/' is your image directory
                echo "</div>"; // blog image
                echo "<div class='blog-content'>";
                echo "<h2 class='blog-title text-truncate h2'><a href='post-details.php?id={$row['id']}&slug={$row['slug']}'>{$row['headline']}</a></h2>";
                echo "<div class='blog-meta'>";
                echo "<i class='fa fa-list-alt'></i>";
                echo "<a href='category.php?id={$row['id']}&slug={$row['slug']}'>{$row['category']}</a>"; 
                echo "</div>";
                echo "<div class='blog-meta'>";
                echo "<i class='fa fa-calendar-alt'></i>";
                echo "<p>{$formattedDate}</p>";
                echo "</div>";
                echo "<div class='blog-text'>";
                echo "<p>{$blogSummary}</p>";
                echo "<a class='btn' href='post-details.php?id={$row['id']}&slug={$row['slug']}'>Read More</a>"; // Link to single blog page with id
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='alert alert-info' role='alert'>No blog posts found.</div>";
        }

        // 4. Close the database connection
        $conn->close();
    ?>

          
        </div>
        <div class="row">
          <div class="col-12">
            <ul class="pagination justify-content-center">
              <li class="page-item disabled">
                <a class="page-link" href="#">Previous</a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item active">
                <a class="page-link" href="#">2</a>
              </li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
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
    <script>
      $(document).ready(function() {
        $('.truncate-3-sentences').each(function() {
          var text = $(this).text();
          var sentences = text.split(/(?<!\w\.\w.)(?<![A-Z][a-z]\.)(?<=\.|\?)\s/g); // Split into sentences, considering abbreviations and initials
          if (sentences.length > 3) {
            var truncatedText = sentences.slice(0, 3).join(' ') + '.'; // Join first 3 sentences
            $(this).text(truncatedText + '...'); // Add ellipsis
          }
        });
      });
    </script>
</body>

</html>