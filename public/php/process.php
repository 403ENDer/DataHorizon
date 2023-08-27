<?php
require_once "vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $to = "harish11ndsh@gmail.com"; // Your email address
    $subject = "New Quote Request from $name";
    $headers = "From: $email";

    if (mail($to, $subject, $message, $headers)) {
        Firebase::redirect("/DataHorizon/index.html?message=success");
    } else {
        Firebase::redirect("/DataHorizon/index.html?message=error&details=" . urlencode(error_get_last()['message']));
    }
} else {
    echo "ki0";
}
?>
