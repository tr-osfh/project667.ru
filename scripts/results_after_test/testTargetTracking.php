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

$sql = "SELECT `reaction_time`, `max_correct_time`, `std_dev`, `date`  FROM `test_target_track` WHERE `user_id` = ?";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p id = 'res_title'>Результаты предыдущих попыток</p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='padding: 7px; text-align: left;'>Среднee время pеакции</th>
            <th style='padding: 10px; text-align: left;'>Точность преследования</th>
            <th style='padding: 10px; text-align: left;'>Стандартное отклонение</th>
            <th style='padding: 10px; text-align: left;'>Дата</th>
            </tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['reaction_time']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['max_correct_time']) . "мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['misses']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['std_dev']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // echo "У вас нет консультаций";
    }

    $stmt->close();  // Закрываем подготовленный запрос
} else {
    echo "Ошибка выполнения запроса: " . $connection->error;  // Выводим ошибку, если запрос не удалось подготовить
}
