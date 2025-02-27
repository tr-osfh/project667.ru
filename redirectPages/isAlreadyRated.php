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

$sql = "SELECT `profname` FROM `profession_data` WHERE `expertID` = ? AND `profid` = ?";

if ($stmt = $connection->prepare($sql)) {
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../redirectPages/alreadyRated.html");
    }
}
