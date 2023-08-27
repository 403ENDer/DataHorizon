<?php
require_once "vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Basic form validation
    if ($password !== $confirm_password) {
        Firebase::redirect("/DataHorizon/registration.html?message=pass " . urlencode(error_get_last()['message']));
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Database connection parameters
    $host = "localhost:3306";
    $dbUsername = "root";
    $dbPassword = "Harihk@1106";
    $dbName = "mydb";

    // Create a database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        Firebase::redirect("/DataHorizon/registration.html?message=user " . urlencode(error_get_last()['message']));
    } else {
        // Insert user data into the "users" table
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            Firebase::redirect("/DataHorizon/login.html?message = res" .urlencode(error_get_last()['message']));
        } else {
            Firebase::redirect("/DataHorizon/registration.html?message=error " . urlencode(error_get_last()['message']));
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
