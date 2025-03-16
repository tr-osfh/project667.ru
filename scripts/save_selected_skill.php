<?php
session_start();


$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка подключения: " . $connection->connect_error);
}

$profession_id = $_POST['profession_id'];
$pvk_id = $_POST['pvk_id'];
$expert_id = $_POST['expert_id'];


$sql = "INSERT INTO final_pvk (profession_id, pvk_id, expert_id) VALUES (?, ?, ?)";
$stmt = $connection->prepare($sql);
$stmt->bind_param("iii", $profession_id, $pvk_id, $expert_id);

if ($stmt->execute()) {
    echo "ПВК успешно сохранен.";
} else {
    echo "Ошибка при сохранении ПВК: " . $stmt->error;
}

$stmt->close();
$connection->close();
