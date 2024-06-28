<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize data
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);

    // Validate input (ensure it's not empty)
    if (empty($categoryName)) {
        echo json_encode(['status' => 'error', 'message' => 'Category name cannot be empty.']);
        exit;
    }

    // Update category in the database
    $stmt = $conn->prepare("UPDATE categories SET category = ?, category_date = NOW() WHERE id = ?"); 
    $stmt->bind_param("si", $categoryName, $categoryId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating category: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
