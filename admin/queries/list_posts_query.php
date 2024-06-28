<?php
include('connect.php');  

$query = "SELECT b.id, b.headline, b.post_date, b.image_name, c.category, b.blog_content 
          FROM blog b 
          LEFT JOIN categories c ON b.category_id = c.id
          ORDER BY b.post_date DESC"; 
$result = $conn->query($query);

$posts = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row; // Fetch the row as an associative array
    }
    echo json_encode(['status' => 'success', 'posts' => $posts]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No posts found.']);
}

$conn->close();
?>
