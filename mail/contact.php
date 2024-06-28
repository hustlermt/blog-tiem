<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize and validate all input
  $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
    $message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

  // Validate email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // Bad Request
    echo json_encode(["success" => false, "message" => "Invalid email address."]);
    exit;
  }

  // Set recipient email address
  $to = "info@tiemcivilstructuralengineers.co.zw"; 

  // Prepare email subject and body
  $subject = "New Contact Form Message from $name";
  $body = "Name: $name\n\nEmail: $email\n\nPhone: $phone\n\nMessage:\n$message";

  // Additional headers (optional)
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";

  // Send the email
  if (mail($to, $subject, $body, $headers)) {
    // Return a JSON response indicating success
    echo json_encode(["success" => true, "message" => "Thank you for your message!"]);
  } else {
    // Return a JSON response indicating failure
    echo json_encode(["success" => false, "message" => "Oops! Something went wrong. Please try again later."]);
  }
} else {
    // Handle invalid requests (not POST)
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
