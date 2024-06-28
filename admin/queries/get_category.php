<?php
include 'connect.php';

$searchTerm = isset($_GET['term']) ? mysqli_real_escape_string($conn, $_GET['term']) : '';

$query = "SELECT id, category FROM categories WHERE category LIKE '%$searchTerm%'";
$result = $conn->query($query);

$categories = array();
while ($row = $result->fetch_assoc()) {
    $categories[] = ['id' => $row['id'], 'category' => $row['category']]; // Use "category" consistently
}

echo json_encode($categories);

$conn->close();
?>
