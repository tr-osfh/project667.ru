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

$sql = "SELECT `overall_avg`, `avg_reaction`, `center_percent`, `std_dev`, `date`  FROM `test_stick_drift` WHERE `user_id` = ?";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p id = 'res_title'>Результаты предыдущих попыток</p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='padding: 7px; text-align: left;'>Среднее отклонение от центра</th>
            <th style='padding: 10px; text-align: left;'>Среднее время реакции</th>
            <th style='padding: 10px; text-align: left;'>Ошибки</th>
            <th style='padding: 10px; text-align: left;'>Cреднее отклонение</th>
            <th style='padding: 10px; text-align: left;'>Процент времени в центре</th>
            </tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['overall_avg']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['avg_reaction']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['center_percent']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['std_dev']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['date']) . "</td>";
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
