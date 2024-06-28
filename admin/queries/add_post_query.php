<?php
include('connect.php');
include 'functions.php';
// Image upload directory
$targetDir = "../../img/blog/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve form data
        $headline = mysqli_real_escape_string($conn, $_POST['headline']);
        $categoryId = mysqli_real_escape_string($conn, $_POST['category_id']);
        $contentText = $_POST['blog_content'];
        $postDate = date('Y-m-d H:i:s'); 
        $slug = generateSlug($headline);

        // 1. Image Upload Handling
        if (!empty($_FILES["image_name"]["name"])) {
            $fileName = basename($_FILES["image_name"]["name"]);
            $newFileName = generateRandomString(36) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $targetFilePath = $targetDir . $newFileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                // Resize and save the image (using GD library for resizing)
                if (resizeImage($_FILES["image_name"]["tmp_name"], $targetFilePath, 750, 400, $fileType)) { // Pass the file type to resizeImage

                    // 2. Insert into Database
                    $stmt = $conn->prepare("INSERT INTO blog (category_id, headline, blog_content, image_name, post_date, slug) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("isssss", $categoryId, $headline, $contentText, $newFileName, $postDate, $slug);

                    if ($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => 'Post added successfully with image!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Error adding post: ' . $stmt->error]);
                    }

                    $stmt->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Image resizing failed.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Please select an image to upload.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]); 
    } 
}

$conn->close();
?>
