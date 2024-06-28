<?php
include('connect.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);

    // Validate input (ensure it's not empty)
    if (empty($categoryName)) {
        echo json_encode(['status' => 'error', 'message' => 'Category name cannot be empty.']);
        exit;
    }

    // Insert category into the database
    $stmt = $conn->prepare("INSERT INTO categories (category, category_date) VALUES (?, NOW())");
    $stmt->bind_param("s", $categoryName);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error adding category: ' . $stmt->error]);
    }

    $stmt->close();
}
$conn->close();
?>
