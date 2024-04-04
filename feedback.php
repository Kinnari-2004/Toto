<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "login_register";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement to insert feedback into database
$stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $name, $email, $feedback, $rating);

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];
$rating = $_POST['rating'];

// // Execute SQL statement
// if ($stmt->execute()) {
//     echo "Feedback submitted successfully!";
// } else {
//     echo "Error: " . $stmt->error;
// }

// Check if email exists in database
$stmt = $conn->prepare("SELECT * FROM feedback WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     // Email exists, update feedback
//     $stmt = $conn->prepare("UPDATE feedback SET name = ?, feedback = ?, rating = ? WHERE email = ?");
//     $stmt->bind_param("ssis", $name, $feedback, $rating, $email);
//     if ($stmt->execute()) {
//         echo "Feedback updated successfully!";
//     } else {
//         echo "Error: " . $stmt->error;
//     }
// } else {
//     // Email does not exist, insert feedback
//     $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)");
//     $stmt->bind_param("sssi", $name, $email, $feedback, $rating);
//     if ($stmt->execute()) {
//         echo "Feedback submitted successfully!";
//     } else {
//         echo "Error: " . $stmt->error;
//     }
// }

if ($result->num_rows > 0) {
    // Email exists, update name and other feedback details
    $stmt = $conn->prepare("UPDATE feedback SET name = ?, feedback = ?, rating = ? WHERE email = ?");
    $stmt->bind_param("ssis", $name, $feedback, $rating, $email);
    if ($stmt->execute()) {
        echo "Feedback updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    // Email does not exist, insert new feedback
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $feedback, $rating);
    if ($stmt->execute()) {
        echo "Feedback submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
