<?php
include('connect.php'); 

if (isset($_GET['categoryId'])) {
    $categoryId = mysqli_real_escape_string($conn, $_GET['categoryId']);

    $query = "SELECT category FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'category' => $row['category']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Category not found']);
    }

    $stmt->close();
}

$conn->close();
?>
