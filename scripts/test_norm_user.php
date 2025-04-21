<?php

$servername = "localhost";
$username = "u3003666_root";
$password = "9MhtHL8QmFHjbiK";
$db = "u3003666_project667";


$connection = new mysqli($servername, $username, $password, $db);
if ($connection->connect_error) {
    die("Ошибка: " . $connection->connect_error);
}

$expert_watch = false;
if(isset($_SESSION['user_test_id'])){
    if ($_SESSION['user_test_id'] != null){
        $id = $_SESSION['user_test_id'];
        $expert_watch = true;
    } else{
        $id = $_SESSION['id'];
    }
};

$tableName = $_SESSION['tableName'];
$norm_list_at = [];
$norm_list_ac = [];
$norm_list_ms = [];
$tableName = $_SESSION['tableName'];
$done = false;
$sql = "
    SELECT 
        avg_time, 
        accuracy, 
        misses
    FROM 
        $tableName 
    WHERE
        user_id = ?
    ORDER BY id DESC
    LIMIT 1;
";

if ($stmt = $connection->prepare($sql)) {
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($line = $result->fetch_assoc()) {
        $user_avg_time = $line['avg_time'];
        $user_accuracy = $line['accuracy'];
        $user_misses = $line['misses'];
        $done = true;
    } 
    $stmt->close();
} else {
    echo "Ошибка подготовки запроса: " . $connection->error;
};

$sql1 = "
    SELECT 
        sex,
        age
    FROM 
        user_data 
   WHERE
        user_id = ?;
";

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
};


if ($done){
    if ($user_sex != null ||  $user_age != 0){
        $sql2 = "
            SELECT 
                t.user_id, 
                t.avg_time, 
                t.accuracy, 
                t.misses, 
                u.sex, 
                u.age
            FROM 
                $tableName t
            INNER JOIN 
                user_data u
            ON 
                t.user_id = u.user_id
            WHERE
                t.user_id != ?
                AND u.sex = ?
                AND (u.age = 0 OR (u.age >= ? - 5 AND u.age <= ? + 5));
        ";

        if ($stmt = $connection->prepare($sql2)) {
            $stmt->bind_param("isii", $id, $user_sex, $user_age, $user_age);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {
                    array_push($norm_list_at, $row['avg_time']);
                    array_push($norm_list_ac, $row['accuracy']);
                    array_push($norm_list_ms, $row['misses']);
                };
                $average_at = array_sum($norm_list_at) / count($norm_list_at);
                $average_ac = array_sum($norm_list_ac) / count($norm_list_ac);
                $average_ms = array_sum($norm_list_ms) / count($norm_list_ms);

                echo "<p id = 'res_title'>Анализ последней попытки:</p>";
                if (!$expert_watch){
                    echo "<p><b>Среднее время реакции: $average_at. Ваше время реакции: $user_avg_time</b></p>";
                    if ($average_at < $user_avg_time){
                        echo "<p>Пока pезультат немного ниже среднего, но это только начало! Можно пройти тест еще раз, и ты обязательно улучшить свой результат!</p>";
                    } else if ($average_at > $user_avg_time){
                        echo "<p>Результат выше среднего — это свидетельствует прекрасной реакции и внимательности к деталям.</p>";
                    } else {
                        echo "<p style='margin-bottom: 20px;'>Твоё время реакции такое же, как и у большинства пользователей.</p>";
                    };
                    echo "<p><b>Средняя точность: $average_ac. Ваша точность: $user_accuracy</b></p>";
                    if ($average_ac - 1 > $user_accuracy){
                        echo "<p>Точность немного ниже среднего, но это только начало! Реакция и точность — это навыки, которые можно развивать. </p>";
                    } else if ($average_ac + 1 < $user_accuracy){
                        echo "<p>Верных попаданий больше, чем у многих пользователей. Это говорит об отличной реакции и внимательности. </p>";
                    } else {
                        echo "<p style='margin-bottom: 20px;'>Точность такая же, как у большинства пользователей.</p>";
                    };
                    echo "<p><b>Среднее количество ошибок: $average_ms. Ваше количество ошибок: $user_misses</b></p>";
                    if ($average_ms - 1 > $user_misses){
                        echo "<p>Меньше ошибок, чем у большинства пользователей. Это говорит о высокой скорости реакции и умении замечать важные детали.</p>";
                    } else if ($average_ms + 1 < $user_misses){
                        echo "<p>Сейчас ошибок чуть больше, чем в среднем, но это только начало.</p>";
                    } else {
                        echo "<p style='margin-bottom: 20px;'>Ты сделал столько же ошибок, сколько и большинство пользователей.</p>";
                    }
                } else {
                    echo "<p><b>Средняя скорость: $average_at. Скорость респондента: $user_avg_time</b></p>";
                    echo "<p><b>Средняя точность: $average_ac. Точность респондента: $user_accuracy</b></p>";
                    echo "<p><b>Среднее количество ошибок: $average_ms. Количество ошибок респондента: $user_misses</b></p>";
                }
            } else {
                if (!$expert_watch){
                    echo "<p id = 'res_title'>Прошел тест первым!</p>";
                    echo "<p>Этот результат станет отправной точкой для других. Это только начало, и есть все шансы стать лучшим!</p>";
                } else {
                    echo "<p id = 'res_title'>Респодент данной категории прошел тест первым</p>";
                }
            }
        }
    } else {
        if (!$expert_watch){
            echo "<p id = 'res_title'>Анализ невозможен, вы не указали пол и возраст </p>";
            echo "<p>Заполните все данные и вернитесь сюда снова, чтобы сравнить свои результаты с другими!</p>";
        } else {
            echo "<p id = 'res_title'>Анализ невозможен, респодент не указал свой пол или возраст!</p>";
        }
    }
};
$_SESSION['user_test_id'] = null;
$connection->close();
?>

