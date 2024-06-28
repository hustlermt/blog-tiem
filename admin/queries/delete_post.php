<?php
include('connect.php');  

if (isset($_POST['postId'])) {
    $postId = mysqli_real_escape_string($conn, $_POST['postId']); 

    $query = "DELETE FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $postId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Post deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting post: ' . $stmt->error]);
    }
    $stmt->close();
}

$conn->close();
?>
