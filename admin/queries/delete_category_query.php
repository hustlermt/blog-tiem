<?php
include('connect.php');

if (isset($_POST['categoryId'])) {
    $categoryId = mysqli_real_escape_string($conn, $_POST['categoryId']);

    // Delete the category
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $categoryId); // Use "i" for integer parameter

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting category: ' . $stmt->error]);
    }
    $stmt->close();
}

$conn->close();
?>
