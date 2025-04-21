<?php
$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";
$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

// Проверяем наличие user_id
if (!isset($_SESSION['id'])) {
    die("Ошибка: пользователь не авторизован");
}
$id = (int)$_SESSION['id'];

// Проверяем, существует ли столбец std_dev
$checkColumn = $connection->query("SHOW COLUMNS FROM `test_chet_sound` LIKE 'std_dev'");
if ($checkColumn->num_rows == 0) {
    $connection->query("ALTER TABLE `test_chet_sound` ADD COLUMN `std_dev` FLOAT");
}

$sql = "SELECT `avg_time`, `accuracy`, `misses`, `std_dev`, `date` FROM `test_chet_sound` WHERE `user_id` = ?";
if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p id='res_title'>Результаты предыдущих попыток</p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr>
                <th style='padding: 7px; text-align: left;'>Средняя реакция</th>
                <th style='padding: 10px; text-align: left;'>Попадания</th>
                <th style='padding: 10px; text-align: left;'>Ошибки</th>
                <th style='padding: 10px; text-align: left;'>Стандартное отклонение</th>
                <th style='padding: 10px; text-align: left;'>Дата</th>
              </tr>";

        while ($line = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['avg_time'] ?? '0') . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['accuracy'] ?? '0') . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['misses'] ?? '0') . "</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['std_dev'] ?? '0') . " мс</td>";
            echo "<td style='padding: 10px; text-align: left'>" . htmlspecialchars($line['date'] ?? 'Нет даты') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // echo "У вас нет консультаций";
    }

    $stmt->close();
} else {
    echo "Ошибка выполнения запроса: " . $connection->error;
}

$connection->close();
?>