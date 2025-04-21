<?php

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    echo "Ошибка: " . $connection->connect_error;
}

// session_start();

$columns = $_SESSION['columns'];
$columns_names = $_SESSION['columns_names'];
$tableName = $_SESSION['tableName'];

$expert_watch = false;
if (isset($_SESSION['user_test_id']) && $_SESSION['user_test_id'] !== null) {
    $id = $_SESSION['user_test_id'];
    $expert_watch = true;
} else {
    $id = $_SESSION['id'];
}

$done = false;
$placeholders = implode(", ", $columns);
$sql = "SELECT $placeholders FROM $tableName WHERE user_id = ? ORDER BY id DESC LIMIT 1";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($line = $result->fetch_assoc()) {
        $userData = $line;
        $done = true;
    } 
    $stmt->close();
} else {
    echo "Ошибка подготовки запроса: " . $connection->error;
}

$sql1 = "SELECT sex, age FROM user_data WHERE user_id = ?";
if ($stmt = $connection->prepare($sql1)) {
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($line = $result->fetch_assoc()) {
        $user_sex = $line['sex'];
        $user_age = $line['age'];
    }
    $stmt->close();
} else {
    echo "Ошибка подготовки запроса: " . $connection->error;
}

if ($done) {
    if (!empty($user_sex) || $user_age != 0) {
        $sql2 = "
            SELECT t.user_id, $placeholders, u.sex, u.age
            FROM $tableName t
            INNER JOIN user_data u ON t.user_id = u.user_id
            WHERE t.user_id != ? AND u.sex = ? AND (u.age = 0 OR (u.age >= ? - 5 AND u.age <= ? + 5))
        ";

        if ($stmt = $connection->prepare($sql2)) {
            $stmt->bind_param("isii", $id, $user_sex, $user_age, $user_age);
            $stmt->execute();
            $result = $stmt->get_result();
            $norm_data = [];

            foreach ($columns as $col) {
                $norm_data[$col] = [];
            }

            while ($row = $result->fetch_assoc()) {
                foreach ($columns as $col) {
                    $norm_data[$col][] = $row[$col];
                }
            }

            if (count($norm_data[$columns[0]]) > 0) {
                echo "<p id='res_title'>Анализ последней попытки:</p>";

                foreach ($columns as $i => $col) {
                    $average = round(array_sum($norm_data[$col]) / count($norm_data[$col]), 2);
                    $user_val = $userData[$col];
                    $col_name = $columns_names[$i]; // Название на русском

                    echo "<p><b>$col_name (среднее): $average. ";
                    echo $expert_watch ? "Результат респондента: $user_val" : "Ваш результат: $user_val";
                    echo "</b></p>";

                    if (!$expert_watch) {
                        if ($col === 'avg_time') {
                            echo $user_val > $average 
                                ? "<p>Пока результат ниже среднего. Пройди тест ещё раз — всё получится!</p>"
                                : "<p>Результат выше среднего — отличная скорость реакции!</p>";
                        } elseif ($col === 'accuracy') {
                            echo $user_val < ($average - 1)
                                ? "<p>Точность ниже средней, но это поправимо — тренируйся!</p>"
                                : ($user_val > ($average + 1)
                                    ? "<p>Ты точнее большинства — круто!</p>"
                                    : "<p>У тебя такая же точность, как у большинства.</p>");
                        } elseif ($col === 'misses') {
                            echo $user_val > ($average + 1)
                                ? "<p>Ошибок чуть больше, чем в среднем. Попробуй ещё раз!</p>"
                                : ($user_val < ($average - 1)
                                    ? "<p>Меньше ошибок, чем у большинства — круто!</p>"
                                    : "<p>Примерно столько же ошибок, сколько у других.</p>");
                        } else {
                            // Общая логика для нестандартных колонок
                            echo $user_val > $average 
                                ? "<p>Значение выше среднего.</p>"
                                : ($user_val < $average
                                    ? "<p>Значение ниже среднего.</p>"
                                    : "<p>Значение соответствует среднему.</p>");
                        }
                    }
                }
            } else {
                echo "<p id='res_title'>" . ($expert_watch ? "Респондент прошёл тест первым." : "Ты прошёл тест первым!") . "</p>";
            }

            $stmt->close();
        }
    } else {
        echo "<p id='res_title'>Анализ невозможен: не указан пол или возраст.</p>";
        echo "<p>" . ($expert_watch 
            ? "Респондент не заполнил данные. Без них невозможно выполнить сравнение." 
            : "Пожалуйста, заполни пол и возраст для анализа.") . "</p>";
    }
}

$_SESSION['user_test_id'] = null;
