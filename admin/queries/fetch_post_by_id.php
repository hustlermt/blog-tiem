<?php
include 'connect.php';

$postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : null;

if (!$postId) {
    echo json_encode(['status' => 'error', 'message' => 'Missing post ID']);
    exit;
}

$query = "SELECT * FROM blog WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $postId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'post' => $post]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Post not found']);
}

$stmt->close();
$conn->close();
?>
