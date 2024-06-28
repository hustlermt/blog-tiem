<?php
// Attempt to connect to the database
$conn = @new mysqli('localhost','root','','tiem');

// Check if the connection was successful
if ($conn->connect_error) {
    $error_message = "Failure to connect to server, please contact admin."; // Set the custom error message
    // Set a flag to indicate a connection error
    $connectionError = true;
}
?>
