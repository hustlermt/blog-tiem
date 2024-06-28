<?php
include 'connect.php';
include 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $postId = isset($_POST['post_id']) ? (int) $_POST['post_id'] : null;
        $headline = isset($_POST['headline']) ? $_POST['headline'] : null;
        $categoryId = isset($_POST['category_id']) ? (int) $_POST['category_id'] : null;
        $contentText = isset($_POST['blog_content']) ? $_POST['blog_content'] : null;
        $slug = generateSlug($headline);
        $postDate = date('Y-m-d H:i:s');

        if (!$postId || !$headline || !$categoryId || !$contentText) {
            throw new Exception('Missing required fields.');
        }

        $imageurl = isset($_POST['old_image']) ? $_POST['old_image'] : null;
        if (!empty($_FILES["postImage"]["name"])) {
            $targetDir = '../../img/blog/'; // Ensure this directory exists
            if (!is_dir($targetDir)) {
                throw new Exception('Target directory does not exist.');
            }
            if (!is_writable($targetDir)) {
                throw new Exception('Target directory is not writable.');
            }
            $fileName = basename($_FILES["postImage"]["name"]);
            $newFileName = generateRandomString(12) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            $targetFilePath = $targetDir . $newFileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $targetFilePath)) {
                    $imageurl = $newFileName;
                } else {
                    throw new Exception('Failed to upload image.');
                }
            } else {
                throw new Exception('Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.');
            }
        }

        $query = "UPDATE blog SET headline = ?, blog_content = ?, category_id = ?, slug = ?, post_date = ?, image_name = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("ssisssi", $headline, $contentText, $categoryId, $slug, $postDate, $imageurl, $postId);
        if (!$stmt->execute()) {
            throw new Exception('Error updating post: ' . $stmt->error);
        }

        echo json_encode(['status' => 'success', 'message' => 'Post updated successfully']);
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
$conn->close();
?>
