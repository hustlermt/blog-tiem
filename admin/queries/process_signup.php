<?php
include('connect.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize all input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $status = 0; 

    // 1. Check for required fields
    if (empty($username) || empty($email) || empty($firstName) || empty($lastName) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
        exit; 
    }

    // 2. Check if username or email already exists (add this block)
    $checkQuery = "SELECT * FROM auth WHERE username = ? OR email = ?";
    $stmtCheck = $conn->prepare($checkQuery);

    if (!$stmtCheck) { // Check if prepare failed
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    
    $stmtCheck->bind_param("ss", $username, $email);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username or email already exists.']);
        exit;
    }

    // 3. Insert new user (only if not a duplicate)
    $insertQuery = "INSERT INTO auth (username, email, firstName, lastName, status, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertQuery);

    if (!$stmtInsert) { // Check if prepare failed
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmtInsert->bind_param("ssssis", $username, $email, $firstName, $lastName, $status, $password);

    if ($stmtInsert->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Account created successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error creating account: ' . $stmtInsert->error]);
    }
    
    // Close statements
    $stmtInsert->close();
    $stmtCheck->close();
}

$conn->close();
?>
