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
    $sex = $_POST['sex'];
    $id = $_SESSION["id"];
    $sql = "UPDATE `user_data` SET `sex`= ? WHERE `user_id`=  $id";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $sex);
    $stmt->execute();
};