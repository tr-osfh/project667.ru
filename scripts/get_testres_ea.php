
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
$tableName = $_SESSION['tableName'];

// Формируем SQL-запрос с JOIN
$sql = "
    SELECT 
        u.username, 
        t.avg_time, 
        t.accuracy, 
        t.misses, 
        t.date 
    FROM 
        $tableName t
    INNER JOIN 
        users u 
    ON 
        t.user_id = u.id;
";

// Выполняем запрос
if ($stmt = $connection->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    // Проверяем, есть ли данные
    if ($result->num_rows > 0) {
        echo "<p id='table_$tableName'>Результаты попыток</p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr>
                <th style='padding: 7px; text-align: left;'>Ник пользователя</th>
                <th style='padding: 10px; text-align: left;'>Средняя реакция</th>
                <th style='padding: 10px; text-align: left;'>Попадания</th>
                <th style='padding: 10px; text-align: left;'>Ошибки</th>
                <th style='padding: 10px; text-align: left;'>Дата</th>
              </tr>";

        // Выводим данные
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($row['avg_time']) . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($row['accuracy']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($row['misses']) . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($row['date']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Тест не был пройден!</p>";
    }

    // Закрываем подготовленный запрос
    $stmt->close();
} else {
    // Если запрос не удалось подготовить
    echo "Ошибка выполнения запроса: " . $connection->error;
}
?>