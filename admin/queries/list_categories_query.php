<?php
include('connect.php'); 

$query = "SELECT id, category FROM categories";
$result = $conn->query($query);

$categories = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = ['id' => $row['id'], 'category' => $row['category']];
    }
    echo json_encode(['status' => 'success', 'categories' => $categories]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No categories found.']);
}

$conn->close();
?>
