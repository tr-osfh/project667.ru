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

$sql = "SELECT avg_time, accuracy, misses, accuracy_percent, early_mean, late_mean, abs_mean, std_dev_abs, std_dev, date  FROM test_three_wheels WHERE user_id = ?";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p id = 'res_title'>Результаты предыдущих попыток</p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr><th style='padding: 7px; text-align: left;'>Средняя реакция</th>
            <th style='padding: 10px; text-align: left;'>Попадания</th>
            <th style='padding: 10px; text-align: left;'>Ошибки</th>
            <th style='padding: 10px; text-align: left;'>Точность в процентах</th>
            <th style='padding: 10px; text-align: left;'>Время ранних ответов</th>
            <th style='padding: 10px; text-align: left;'>Вревмя поздних ответов</th>
            <th style='padding: 10px; text-align: left;'>Время по модулю</th>
            <th style='padding: 10px; text-align: left;'>Отклонение по модулю</th>
            <th style='padding: 10px; text-align: left;'>Отклонение с учетом знака</th>
            <th style='padding: 10px; text-align: left;'>Дата</th>
            </tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['avg_time']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['accuracy']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['avg_time']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['accuracy_percent']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['early_mean']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['late_mean']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['abs_mean']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['std_dev_abs']) . "</td>";
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
