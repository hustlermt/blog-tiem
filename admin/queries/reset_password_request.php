<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the email exists
    $query = "SELECT id FROM auth WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $expFormat = mktime(
            date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y")
        );
        $expDate = date("Y-m-d H:i:s", $expFormat);

        $updateQuery = "UPDATE auth SET token = '$token', exp_date = '$expDate' WHERE email = '$email'";
        if ($conn->query($updateQuery) === TRUE) {
            $resetLink = "https://tiemcivilstructuralengineers.co.zw/new-password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Click on this link to reset your password: " . $resetLink;
            $headers = "From: no-reply@tiemcivilstructuralengineers.co.zw\r\n";
            mail($email, $subject, $message, $headers);

            echo json_encode(['status' => 'success', 'message' => 'Password reset link sent to your email.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    }
}
$conn->close();
?>
