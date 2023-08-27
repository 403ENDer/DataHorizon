<?php
require_once "vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

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

    // Prepare and execute a SQL query to retrieve user data
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Redirect to the index page on successful login
            Firebase::redirect("/DataHorizon/index.html");
            exit();
        } else {
            Firebase::redirect("/DataHorizon/login.html?message=wrong " . urlencode(error_get_last()['message']));
        }
    } else {
        Firebase::redirect("/DataHorizon/login.html?message=no " . urlencode(error_get_last()['message']));
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Redirect back to login.php with error message
    
}
?>
