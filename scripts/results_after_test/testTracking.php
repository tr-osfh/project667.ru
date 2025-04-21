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

$sql = "SELECT `total_clicks`, `click_per_minute`, `stats_avg`, `stats_std`, `avg_click`, `date`  FROM `test_tracking` WHERE `user_id` = ?";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p id = 'res_title'>Результаты предыдущих попыток</p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='padding: 7px; text-align: left;'>Всего кликов</th>
            <th style='padding: 10px; text-align: left;'>Кликов в минуту</th>
            <th style='padding: 10px; text-align: left;'>Среднее время между кликами</th>
            <th style='padding: 10px; text-align: left;'>Среднеквадратичное отклонение</th>
            <th style='padding: 10px; text-align: left;'>Среднее количество кликов в секунду</th>
            <th style='padding: 10px; text-align: left;'>Дата</th>
            </tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['total_clicks']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['click_per_minute']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['stats_avg']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['stats_std']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['avg_click']) . "</td>";
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
