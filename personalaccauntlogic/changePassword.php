<?php
session_start();
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);


if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pswd = htmlspecialchars($_POST["password"]);
    $pswd2 = htmlspecialchars($_POST["password2"]);
    if ($pswd == $pswd2) {
        $id = $_SESSION['id'];
        $sql = "UPDATE `users` SET `password`= ? WHERE `id`=  $id";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $pswd);
        $stmt->execute();
    }
}

header("Location:/redirectPages/goPA.php");
exit;
