<?php
session_start();

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);



if ($connection->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Ошибка подключения: ' . $connection->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expert_id = $_SESSION['id'];
    $rates = $_SESSION['selected_pvk'];
    foreach ($rates as $rate) {
        $sql = "INSERT INTO `selectedPVK` (`pvk_id`, `expert_id`) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ss", $rate, $expert_id);
        $stmt->execute();
        $stmt->close();
        echo $rate;
    }
    $connection->close();
}
