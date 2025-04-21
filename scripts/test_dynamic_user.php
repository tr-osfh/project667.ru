<?php

include_once 'calculateImprovement.php';

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";

$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$done = true;

if(isset($_SESSION['user_test_id'])){
    if ($_SESSION['user_test_id'] != null){
        $id = $_SESSION['user_test_id'];
    } else{
        $id = $_SESSION['id'];
    }
};

$tableName = $_SESSION['tableName'];

$sqlFirst = "SELECT avg_time, accuracy, misses FROM $tableName WHERE user_id = ? ORDER BY id ASC LIMIT 1";
if ($stmt = $connection->prepare($sqlFirst)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($line = $result->fetch_assoc()) {
        $first_avg_time = $line['avg_time'];
        $first_accuracy = $line['accuracy'];
        $first_misses = $line['misses'];
    } else {
        $done = false;
    }
    $stmt->close();
} else {
    die("Ошибка подготовки запроса: " . $connection->error);
}

// Получаем последнюю попытку
$sqlLast = "SELECT avg_time, accuracy, misses FROM $tableName WHERE user_id = ? ORDER BY id DESC LIMIT 1";
if ($stmt = $connection->prepare($sqlLast)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($line = $result->fetch_assoc()) {
        $last_avg_time = $line['avg_time'];
        $last_accuracy = $line['accuracy'];
        $last_misses = $line['misses'];
    } else {
        $done = false;
    }
    $stmt->close();
} else {
    die("Ошибка подготовки запроса: " . $connection->error);
}

// Получаем предпоследнюю попытку
$sqlSecondLast = "SELECT avg_time, accuracy, misses FROM $tableName WHERE user_id = ? ORDER BY id DESC LIMIT 1 OFFSET 1";
if ($stmt = $connection->prepare($sqlSecondLast)) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($line = $result->fetch_assoc()) {
        $secondlast_avg_time = $line['avg_time'];
        $secondlast_accuracy = $line['accuracy'];
        $secondlast_misses = $line['misses'];
    } else {
        // Если предпоследней попытки нет, выводим только сравнение первой и последней
        $secondlast_avg_time = null;
        $secondlast_accuracy = null;
        $secondlast_misses = null;
    }
    $stmt->close();
} else {
    die("Ошибка подготовки запроса: " . $connection->error);
}

if ($done){
    echo "<p id='res_title'>Динамика прохождения теста</p>";

    if ($secondlast_avg_time !== null && $secondlast_accuracy !== null && $secondlast_misses !== null) {
        echo "<p><b>Сравним последние два прохождения</b></p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr>
                <th style='padding: 7px; text-align: left;'>Средняя реакция</th>
                <th style='padding: 10px; text-align: left;'>Попадания</th>
                <th style='padding: 10px; text-align: left;'>Ошибки</th>
            </tr>";
        echo "<tr>
                <td style='padding: 10px; text-align: left'>$last_avg_time мс</td>
                <td style='padding: 10px; text-align: left'>$last_accuracy</td>
                <td style='padding: 10px; text-align: left'>$last_misses</td>
            </tr>";
        echo "<tr>
                <td style='padding: 10px; text-align: left'>$secondlast_avg_time мс</td>
                <td style='padding: 10px; text-align: left'>$secondlast_accuracy</td>
                <td style='padding: 10px; text-align: left'>$secondlast_misses</td>
            </tr>";
        echo "</table>";
        echo "<p style=' text-align: left;'>" . calculateImprovement($secondlast_avg_time, $last_avg_time, "скорость") . "</p>";
        echo "<p style=' text-align: left;'>" . calculateImprovement($secondlast_accuracy, $last_accuracy, "точность") . "</p>";
        echo "<p style=' text-align: left;'>" . calculateImprovement($secondlast_misses, $last_misses, "ошибки") . "</p>";
    } else if ($secondlast_avg_time == null && $secondlast_accuracy == null && $secondlast_misses == null){
        echo "<p>Пока была только одна попытка.</p>";
    } if ($first_avg_time !== $last_avg_time || $first_accuracy !== $last_accuracy || $first_misses !== $last_misses) {
        echo "<p><b>Сравним первое и последнее прохождение теста</b></p>";
        echo "<table style='width: 100%; border-collapse: collapse;'>";
        echo "<tr>
                <th style='padding: 7px; text-align: left;'>Средняя реакция</th>
                <th style='padding: 10px; text-align: left;'>Попадания</th>
                <th style='padding: 10px; text-align: left;'>Ошибки</th>
            </tr>";
        echo "<tr>
                <td style='padding: 10px; text-align: left'>$first_avg_time мс</td>
                <td style='padding: 10px; text-align: left'>$first_accuracy</td>
                <td style='padding: 10px; text-align: left'>$first_misses</td>
            </tr>";
        echo "<tr>
                <td style='padding: 10px; text-align: left'>$last_avg_time мс</td>
                <td style='padding: 10px; text-align: left'>$last_accuracy</td>
                <td style='padding: 10px; text-align: left'>$last_misses</td>
            </tr>";
        echo "</table>";
        echo "<p style=' text-align: left;'>" . calculateImprovementV2($first_avg_time, $last_avg_time, "скорость") . "</p>";
        echo "<p style=' text-align: left;'>" . calculateImprovementV2($first_accuracy, $last_accuracy, "точность") . "</p>";
        echo "<p style=' text-align: left;'>" . calculateImprovementV2($first_misses, $last_misses, "ошибки") . "</p>";
    }
}
$_SESSION['user_test_id'] = null;
$connection->close();
?>