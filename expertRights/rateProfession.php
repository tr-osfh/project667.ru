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
    $id = htmlspecialchars($_POST["id"]);
    $value1 = htmlspecialchars($_POST["value1"]);
    $value2 = htmlspecialchars($_POST["value2"]);
    $value3 = htmlspecialchars($_POST["value3"]);
    $value4 = htmlspecialchars($_POST["value4"]);
    $value5 = htmlspecialchars($_POST["value5"]);
    $value6 = htmlspecialchars($_POST["value6"]);
    $value7 = htmlspecialchars($_POST["value7"]);
    $sql = "INSERT INTO `profession_data` (`value1`, `value2`, `value3`, `value4`, `value5`, `value6`, `value7`, `profid`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssss", $value1, $value2, $value3, $value4, $value5, $value6, $value7, $id);
    $stmt->execute();
    header('Location:https://group667.ru/PA/EA/expertpanel.php');
}
