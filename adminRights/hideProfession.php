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
    $added = 0;
    $sql = "UPDATE `professions` SET `added`= ? WHERE `id`=  ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $added, $id);
    $stmt->execute();
}

header('Location:https://group667.online/PA/AA/adminpanel.php');
