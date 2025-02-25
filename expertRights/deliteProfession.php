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
    $id = htmlspecialchars($_POST["id"]);
    $connection->query("SET FOREIGN_KEY_CHECKS = 0");
    $sql = "DELETE FROM `professions` WHERE `id`= ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $connection->query("SET FOREIGN_KEY_CHECKS = 1");
    header('Location:https://group667.ru/PA/EA/expertpanel.php');
}
