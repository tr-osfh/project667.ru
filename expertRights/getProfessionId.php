<?php

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profession_id = htmlspecialchars($_POST["id"]);
}
