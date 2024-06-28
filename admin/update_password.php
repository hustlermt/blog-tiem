<?php
include 'queries/connect.php';
include 'queries/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the token is valid and not expired
    $query = "SELECT email FROM auth WHERE token = '$token' AND exp_date >= NOW()";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Update the password
        $updateQuery = "UPDATE auth SET password = '$newPassword', token = NULL, exp_date = NULL WHERE email = '$email'";
        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or expired token.']);
    }
}
$conn->close();
?>
