<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT id, username, password, status FROM auth WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password']; // Get the hashed password from the database
        $user_status = $row['status']; // Get the user status
        if (password_verify($password, $hashedPassword) && $user_status == 1) {
            // Login successful, set session variables
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username']; 
            echo json_encode(['status' => 'success']);
        } elseif(password_verify($password, $hashedPassword) && $user_status == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Your account is inactive please contact admin']);
        }
        else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password']); 
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Username not found']);
    }

    $stmt->close();
}

$conn->close();
?>
