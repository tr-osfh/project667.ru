<?php
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);

if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$id = $_SESSION['id'];

$sql = "SELECT `id`, `data_time` FROM `consultations` WHERE `consultant_id` = ? AND `active` = 0";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='padding: 10px; text-align: left;'>ID</th>
            <th style='padding: 10px; text-align: left;'>date&time</th></tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px;'>" . $line['id'] . "</td>";
            echo "<td style='padding: 10px;'>" . htmlspecialchars($line['data_time']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "У вас нет консультаций";
    }

    $stmt->close();
} else {
    echo "Ошибка выполнения запроса: " . $connection->error;
}
