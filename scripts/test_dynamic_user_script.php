<?php
include_once 'calculateImprovement.php';

// session_start();

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка подключения: " . $connection->connect_error);
}

$done = true;

// Получаем ID пользователя
$id = $_SESSION['user_test_id'] ?? $_SESSION['id'] ?? null;
if ($id === null) {
    echo "Ошибка: ID пользователя не найден.";
    return;
}

// Получаем имя таблицы и список колонок из сессии
$tableName = $_SESSION['tableName'];
$columns_names = $_SESSION['columns_names'];
$columns = $_SESSION['columns'];

if (!$tableName || !$columns || !is_array($columns)) {
    echo "Ошибка: Недостаточно данных в сессии.";
    return;
}

// Проверка на валидность имени таблицы и колонок
function isValidIdentifier($str) {
    return preg_match('/^[a-zA-Z0-9_]+$/', $str);
}

if (!isValidIdentifier($tableName)) {
    echo "Ошибка: Неверное имя таблицы.";
    return;
}

foreach ($columns as $col) {
    if (!isValidIdentifier($col)) {
        echo "Ошибка: Неверное имя колонки: $col";
        return;
    }
}

$columnList = implode(", ", $columns);

// Получение данных (оборачиваем в функцию для переиспользования)
function getAttemptData($connection, $tableName, $columnList, $id, $order, $offset = 0) {
    $sql = "SELECT $columnList FROM $tableName WHERE user_id = ? ORDER BY id $order LIMIT 1 OFFSET $offset";
    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data ?: null;
    } else {
        die("Ошибка подготовки запроса: " . $connection->error);
    }
}

$first = getAttemptData($connection, $tableName, $columnList, $id, "ASC");
$last = getAttemptData($connection, $tableName, $columnList, $id, "DESC");
$secondLast = getAttemptData($connection, $tableName, $columnList, $id, "DESC", 1);

if (!$first || !$last) {
    $done = false;
}

if ($done) {
    echo "<p id='res_title'>Динамика прохождения теста</p>";

    // Сравнение последних двух
    if ($secondLast) {
        echo "<p><b>Сравним последние два прохождения</b></p>";
        echo "<table style='width: 100%; border-collapse: collapse;'><tr>";
        foreach ($columns_names as $name) {
            echo "<th style='padding: 10px; text-align: left;'>$name</th>";
        }
        echo "</tr><tr>";
        foreach ($columns as $col) {
            echo "<td style='padding: 10px; text-align: left'>{$last[$col]}</td>";
        }
        echo "</tr><tr>";
        foreach ($columns as $col) {
            echo "<td style='padding: 10px; text-align: left'>{$secondLast[$col]}</td>";
        }
        echo "</tr></table>";

        foreach ($columns as $i => $col) {
            echo "<p style='text-align: left;'><b>{$columns_names[$i]}:</b> " . calculateImprovement($secondLast[$col], $last[$col], $col) . "</p>";
        }
    } else {
        echo "<p>Пока была только одна попытка.</p>";
    }

    // Сравнение первого и последнего
    if ($first !== $last) {
        echo "<p><b>Сравним первое и последнее прохождение теста</b></p>";
        echo "<table style='width: 100%; border-collapse: collapse;'><tr>";
        foreach ($columns_names as $name) {
            echo "<th style='padding: 10px; text-align: left;'>$name</th>";
        }
        echo "</tr><tr>";
        foreach ($columns as $col) {
            echo "<td style='padding: 10px; text-align: left'>{$first[$col]}</td>";
        }
        echo "</tr><tr>";
        foreach ($columns as $col) {
            echo "<td style='padding: 10px; text-align: left'>{$last[$col]}</td>";
        }
        echo "</tr></table>";

        foreach ($columns as $i => $col) {
            echo "<p style='text-align: left;'><b>{$columns_names[$i]}:</b> " . calculateImprovementV2($first[$col], $last[$col], $col) . "</p>";
        }
    }
}

$_SESSION['user_test_id'] = null;
$connection->close();
?>
